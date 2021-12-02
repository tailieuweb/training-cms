<?php
class MetaModelWpf extends ModelWpf {
	private $maxTextLength = 150;
	private $maxKeyLength = 32;
	public $maxKeySize = 4;
	private $valsModel = array();
	private $keysArray = array();
	private $existMB = false;
	public $metaVarSuf = '#wpfvar#';
	public $startLockLimit = 20;

	public function __construct() {
		$this->existMB = function_exists('mb_substr');
		$this->_setTbl('meta_data');
		$this->setIndexes(array(
			'product_key' => 'INDEX `product_key` (`product_id`, `key_id`)',
			'key_id' => 'INDEX `key_id` (`key_id`)',
			'key_dec' => 'INDEX `key_dec` (`val_dec`, `key_id`)',
			'key_int' => 'INDEX `key_int` (`val_int`, `key_id`)',
			'val_id' => 'INDEX `val_id` (`val_id`)'
		));
	}

	private function setKeys() {
		$this->keysArray = array();
		$this->keysSQL = array();
		$len = $this->maxKeySize;
		for ($k = 2; $k <= $len; $k++) {
			$this->keysArray['key' . $k] = '';
		}
	}

	public function recalcMetaValues( $productId = 0, $params = array() ) {
		$result = $this->doRecalcMetaValues($productId, $params);
		if (!$result && FrameWpf::_()->getModule('options')->getModel()->get('logging') == 1) {
			$logger = wc_get_logger();
			if ($logger) {
				$logger->warning(UtilsWpf::jsonEncode($this->getErrors()), array('source' => 'wpf-meta-indexing'));
			} 
		}
		return $result;
	}
	
	public function doRecalcMetaValues( $productId, $params ) {
		if (!empty($productId) && !is_numeric($productId)) {
			return false;
		}
		$isAllProducts = empty($productId);
		$isAllKeys = empty($params);
		$fullRecalc = $isAllProducts && $isAllKeys;
		$keysModel = FrameWpf::_()->getModule('meta')->getModel('meta_keys');
		$optModel = FrameWpf::_()->getModule('options')->getModel();

		if ($fullRecalc && $optModel->get('start_indexing') == 2) {
			if (microtime(true) - $optModel->getChanged('start_indexing') > $this->startLockLimit * 60) {
				$optModel->save('start_indexing', 1);
			} else {
				$this->pushError('Wait. The calculation is already running ...');
				return false;
			}
		}
		if ($fullRecalc || $optModel->get('start_indexing') != 1) {
			if (!$keysModel->controlFiltersMetaKeys(true)) {
				$this->pushError($keysModel->getErrors());
				return false;
			}
			//$optModel->save('start_indexing', 1);
			/*if (!$keysModel->resetLockedKeys()) {
				$this->pushError($keysModel->getErrors());
				return false;
			}*/
		}
		if ($fullRecalc) {
			$optModel->save('start_indexing', 2);
		}

		if ($isAllKeys) {
			$params['parent'] = 0; 
		} 
		
		$keys = $keysModel->getKeysForRecalc($params);
		if (count($keys) == 0) {
			return true;
		}
		$this->addIndexes();
				
		$whereProduct = '';

		if (!$isAllProducts) {
			$product = wc_get_product($productId);
			if (!$product) {
				return false;
			}
			$ids = $product->get_type() == 'variable' ? $product->get_children() : array();
			$ids[] = $productId;
			$productList = ( count($ids) > 1 ? ' IN (' . implode(',', $ids) . ')' : '=' . $productId );
			$whereProduct = 'product_id' . $productList;
		}

		$isKnownKeyList = true;
		$whereKeys = $whereProduct;
		if (!$isAllKeys) {
			$list = '';
			foreach ($keys as $key) {
				$list .= $key['id'] . ',';
				if (!empty($key['meta_like'])) {
					$isKnownKeyList = false;
				}
			}
			if (!empty($list)) {
				$whereKeys .= ( $isAllProducts ? '' : ' AND ' ) . ' key_id IN (' . substr($list, 0, -1) . ')';
			}
		}
		

		if ($isKnownKeyList) {
			if ($isAllProducts) {
				$this->dropIndexes();
			}
			if (!$this->delete($whereKeys)) {
				return false;
			}
		}
		$valsModel = FrameWpf::_()->getModule('meta')->getModel('meta_values');
		$this->valsModel = $valsModel;

		$from = ' FROM `#__postmeta` as m INNER JOIN `#__posts` as p ON (p.id=m.post_id)';
		$where = " WHERE p.post_type IN ('product', 'product_variation') AND p.post_status IN('publish')" . ( $isAllProducts ? '' : ' AND p.id' . $productList );

		$tempTable = false;
		if ($isAllProducts) {
			$tempTable = FrameWpf::_()->getModule('woofilters')->createTemporaryTable('wpf_meta_calc', "SELECT id, post_parent, post_type, IF(p.post_type='product_variation',1,0) as is_var FROM `#__posts` as p" . $where);
			$from = ' FROM `#__postmeta` as m  FORCE INDEX (meta_key) INNER JOIN ' . $tempTable . ' as p ON (p.id=m.post_id)';
			$where = ' WHERE 1=1';
		}
		
		$insert = 'INSERT INTO `@__meta_data` (product_id, is_var, key_id, ';
		$maxKeySize = $this->maxKeySize;
		$maxTextLength = $this->maxTextLength;
		$this->setKeys();
		$keyRecalc = array();
		
		$limit = 1000;
		$maxCountProducts = DbWpf::get('SELECT count(*) FROM `#__posts` as p ' . $where, 'one');
		if (false === $maxCountProducts) { 
			$this->pushError(DbWpf::getError());
			return false;
		}
		
		$maxCountProducts += 100;

		foreach ($keys as $key) {
			$keyName = $key['meta_key'];
			$isLike = !empty($key['meta_like']);
			$parent = $key['id'];
			
			if ($isLike) {
				$keysData = DbWpf::get('SELECT DISTINCT meta_key' . ( $isAllProducts ? ' FROM `#__postmeta` as m FORCE INDEX (meta_key) WHERE ' : $from . $where . ' AND ' ) . " m.meta_key LIKE '" . $keyName . "'", 'col');
				if (false === $keysData) { 
					$this->pushError(DbWpf::getError());
					return false;
				}
				if (empty($keysData) && $isAllProducts) {
					if (!$keysModel->updateKeyData($key['id'], array('status' => 5))) {
						$this->pushError($keysModel->getErrors());
						return false;
					};
					continue;
				}
			} else {
				$keysData = array($keyName);
			}
			foreach ($keysData as $keyName) {
				set_time_limit(300);
				$keyData = $keysModel->getKeyData($keyName, true);
				if ($isLike) {
					if (empty($keyData)) {
						$id = $keysModel->saveKeyData(array_merge($key, array('meta_key' => $keyName, 'meta_like' => 0, 'parent' => $key['id'], 'status' => 0)));
						if ($id) {
							$keyData['id'] = $id;
						} else {
							$this->pushError($keysModel->getErrors());
							return false;
						}
					}
				}
				if (empty($keyData)) {
					continue;
				}
				$keyId = $keyData['id'];
				$status = $keyData['status'];
				$needLock = $isAllProducts;
				$needRecalc = false;
				if (2 == $status) {
					if ($keysModel->isOldLock($keyData['lock_duration'])) {
						if (!$isAllProducts) {
							$needRecalc = true;
						}
					} else {
						continue;
					}
				}
				//$keyMode = $key['meta_mode'];
				$keyType = DispatcherWpf::applyFilters('getMetaFieldType', $key['meta_type'], $keyName);
				if (false === $keyType) {
					continue;
				}
				if ($keyType != $key['meta_type'] && $isAllProducts) {
					$needRecalc = true;
				}

				if ($needRecalc || $needLock) {
					if (!$keysModel->updateKeyData($keyId, array('meta_type' => $keyType, 'status' => $needLock ? 2 : 0))) { // set new lock
						$this->pushError($keysModel->getErrors());
						return false;
					}
				}

				if (!$isKnownKeyList && !$this->delete('key_id=' . $keyId . ( $isAllProducts ? '' : ' AND ' . $whereProduct ))) {
					return false;
				}
				$isMetaVar = strpos($keyName, $this->metaVarSuf) != false;
				$keyNameVar = str_replace($this->metaVarSuf, '', $keyName);
				if (empty($keyData['taxonomy'])) {
					if (!DbWpf::query("UPDATE @__meta_keys SET taxonomy='" . $keyNameVar . "' WHERE id=" . $keyId)) {
						return false;
					}
				}

				$calculated = false;
				$func = 'saveMeta' . $keyName;
				if (method_exists($this, $func )) {
					if ($this->$func($productId, $keyData, $tempTable)) {
						$calculated = true;
						$status = 1;
					} else {
						return false;
					}
				}

				if (!$calculated) {
					
					$query = '';
					$whereMeta = $where . " AND m.meta_key='" . $keyName . "'";
					if ($isMetaVar) {
						$keyDataVar = $keysModel->getKeyData($keyNameVar, true);					
						if (empty($keyDataVar)) { 
							continue;
						}
					} else {
						$keyRecalc[] = $keyId;
					}
					$selectType = ( $tempTable ? 'p.is_var,' : "IF(p.post_type='product_variation',1,0) as is_var," );

					switch ($keyType) {
						case 0:							
							$join = ' JOIN @__meta_values as v ON (v.key_id=' . ( $isMetaVar ? $keyDataVar['id'] : $keyId ) . ' AND v.value=CAST(meta_value AS CHAR(' . $maxTextLength . '))' ;
							for ($k = 2; $k <= $maxKeySize; $k++) {
								$join .= ' AND v.key' . $k . "=''";
							}
							$join .= ')';

							if ($isMetaVar) {
								$query = $insert . 'val_id) SELECT DISTINCT post_parent,0,' . $keyId . ',v.id' . $from . ' INNER ' . $join . $where . " AND m.meta_key='" . $keyNameVar . "' AND p.post_type='product_variation'";
							} else {
								$query = 'INSERT IGNORE INTO @__meta_values (key_id, value)' .
									' SELECT DISTINCT ' . $keyId . ',CAST(meta_value AS CHAR(' . $maxTextLength . '))' .
									$from . ' LEFT ' . $join .
									$whereMeta . ' AND ISNULL(v.id)' . ( strpos($keyName, 'attribute_') === 0 ? '' : " AND m.meta_value!=''" );
								if (DbWpf::query($query)) {
									$query = $insert . 'val_id) SELECT post_id,' . $selectType . $keyId . ',v.id' . $from . ' INNER ' . $join . $whereMeta;
								} else {
									$this->pushError(DbWpf::getError());
									return false;
								}
							}

							break;
						case 1:
							$query = $insert . 'val_dec) SELECT post_id,' . $selectType . $keyId . ',CAST(meta_value AS DECIMAL(19,4))' . $from . $whereMeta;
							break;
						case 2:
							$query = $insert . 'val_int) SELECT post_id,' . $selectType . $keyId . ',CAST(meta_value AS SIGNED)' . $from . $whereMeta;
							break;
						case 3:
							$query = $insert . 'val_int, val_dec) SELECT post_id,' . $selectType . $keyId . ',ROUND(CAST(meta_value AS DECIMAL(19,4))),CAST(meta_value AS DECIMAL(19,4))' . $from . $whereMeta;
							break;
						case 7:
						case 8:
						case 9:
							//$query = $insert . 'meta_dec) SELECT post_id,' . $keyId . ',CAST(meta_value AS DECIMAL(19,4)) ' . $from . $whereMeta;
							$valsModel->selectMetaValues($keyId);
							$offset = 0;
							if (!$isKnownKeyList) {
								$this->dropIndexes();
							}
							$valsModel->dropIndexes();

							$limitQuery = 'SELECT post_id, ' . $selectType . ' meta_value' . $from . $whereMeta . ' ORDER BY meta_id LIMIT ';
							do {
								$data = DbWpf::get($limitQuery . $offset . ',' . $limit);
								if (false === $data) { 
									$this->pushError(DbWpf::getError());
									return false;
								}
								$j = 0;
								$lastData = count($data) - 1;
								$insertValues = '';
								foreach ($data as $k => $values) {
									$valuesArr = ( 7 == $keyType ? $values['meta_value'] : unserialize($values['meta_value']) );
									if (is_array($valuesArr)) {
										$j++;
										
										if (9 == $keyType) {
											$insValues = $this->saveMetaList($keyId, $values['post_id'], $values['is_var'] , $valuesArr);
										} else {
											$insValues = $this->saveMetaArray($keyName, $keyId, $values['post_id'], $values['is_var'], $valuesArr);
										}
										if (false === $insValues) {
											return false;
										}
										if (!empty($insValues)) {
											$insertValues .= $insValues;
										}
									}
									if ($j >= 10 || $k >=  $lastData) {
										if (!empty($insertValues)) {
											if (!DbWpf::query($insert . ' val_id) VALUES ' . substr($insertValues, 0, -1))) {
												$this->pushError(DbWpf::getError());
												return false;
											}
										}
										$insertValues = '';
										$j = 0;
									}
								}
								$offset += $limit;
							} while ( !empty($data) && ( $maxCountProducts >= $offset ) && ( count($data) >= $limit ) );
							$status = 1;

							if (!$isKnownKeyList) {
								$this->addIndexes();
							}
							$valsModel->addIndexes();
							break;
						
						default:
							$status = 10;
							break;
					}
					if (!empty($query)) {
						if (DbWpf::query($query)) {
							$status = 1;
						} else {
							$this->pushError(DbWpf::getError());
							return false;
						}
					}
				}
				if ($isAllProducts && !$keysModel->updateKeyData($keyId, array('status' => $status))) {
					$this->pushError($keysModel->getErrors());
					return false;
				}
			}
			if ($isLike) {
				$keysModel->updateKeyData($parent, array('status' => 1));
			}
		}
		set_time_limit(300);
		if (!$this->addIndexes()) {
			return false;
		}
		if (!empty($keyRecalc)) {
			$attrKey = $keysModel->getKeyData('_product_attributes');
			$keys = $this->keysArray;
			$parentKey = $keysModel->getKeyData('attribute_%');
			if (!empty($attrKey) && in_array($attrKey['id'], $keyRecalc) && !empty($parentKey)) {
				$attrKeyId = $attrKey['id'];
				$parentKeyId = $parentKey['id'];

				$attributes = DbWpf::get('SELECT key3, id, value FROM @__meta_values WHERE key_id=' . $attrKeyId . " AND key2='is_variation' AND key4=''");
				$attrIds = array();
				$varIds = array();
				foreach ($attributes as $k => $data) {
					$key = $data['key3'];
					$id = $data['id'];
					$attrIds[$key][] = $id;
					if (1 == $data['value']) {
						$varIds[$key] = $id;
					}
				}
				foreach ($attrIds as $key => $ids) {
					set_time_limit(300);
					$keyName = 'attribute_' . $key;
					$keyData = $keysModel->getKeyData($keyName, false);
					if (empty($keyData)) {
						$keyId = $keysModel->saveKeyData(array_merge($parentKey, array('meta_key' => $keyName, 'meta_like' => 0, 'parent' => $parentKeyId, 'status' => 0)));
					} else {
						$keyId = $keyData['id'];
					}
					$isNew = false;
					$valId = $valsModel->getMetaValueId($keyId, '', $keys);
					if (empty($valId)) {
						$valsModel->resetMetaValues();
						$valId = $valsModel->insertValueId($keyId, $keys, '');
						$isNew = true;
					}
					if (empty($valId)) {
						$this->pushError($valsModel->getErrors());
						return false;
					}
					if (isset($varIds[$key])) {
						$query = 'DELETE d FROM @__meta_data as d' .
							' INNER JOIN ' . ( $tempTable ? $tempTable : ' `#__posts` ' ) . ' as p ON (p.id=d.product_id)' .
							' INNER JOIN `#__posts` as pp ON (pp.id=p.post_parent)' .
							' LEFT JOIN @__meta_data as mp ON (mp.product_id=pp.id AND mp.key_id=' . $attrKeyId . ' AND mp.val_id=' . $varIds[$key] . ')' .
							$where . " AND p.post_type='product_variation' AND d.key_id=" . $keyId . ' AND d.is_var=1 AND ISNULL(mp.id)';
					} else {
						$query = 'DELETE d FROM @__meta_data as d' .
							' INNER JOIN ' . ( $tempTable ? $tempTable : ' `#__posts` ' ) . ' as p ON (p.id=d.product_id)' .
							$where . " AND p.post_type='product_variation' AND d.key_id=" . $keyId . ' AND d.is_var=1';
					}
					if (!DbWpf::query($query)) {
						$this->pushError(DbWpf::getError());
						return false;
					}

					$query = $insert . 'val_id) SELECT p.id,1,' . $keyId . ',' . $valId . 
						' FROM ' . ( $tempTable ? $tempTable : ' `#__posts` ' ) . ' as p' .
						' INNER JOIN `#__posts` as pp ON (pp.id=p.post_parent)' .
						' INNER JOIN @__meta_data as mp ON (mp.product_id=pp.id AND mp.key_id=' . $attrKeyId . ' AND mp.val_id IN (' . implode(',', $ids) . '))' .
						' LEFT JOIN @__meta_data as m ON (m.product_id=p.id AND m.key_id=' . $keyId . ')' .
						$where . " AND p.post_type='product_variation' AND ISNULL(m.id)";
					if (DbWpf::query($query)) {
						if ($isNew && !$keysModel->updateKeyData($keyId, array('status' => 1))) {
							$this->pushError($keysModel->getErrors());
							return false;
						}
					} else {
						$this->pushError(DbWpf::getError());
						return false;
					}
				}
			
			}
			set_time_limit(300);

			if (!$valsModel->recalcValuesCount($isAllKeys ? array() : $keyRecalc)) {
				$this->pushError($valsModel->getErrors());
				return false;
			}
		}
		if ($fullRecalc) {
			$optModel->save('start_indexing', 1);
		}
		
		return true;
	}

	public function saveMetaArray( $keyName, $keyId, $productId, $isVar, $data ) {
		$func = 'saveMetaArray' . $keyName;
		if (method_exists($this, $func )) {
			return $this->$func($keyId, $productId, $isVar, $data );
		}
		$insert = '';
		$queryValue = '(' . $productId . ',' . $isVar . ',' . $keyId . ',';
		$keys = $this->keysArray;
		$valsModel = $this->valsModel;
		foreach ($data as $k2 => $v2) {
			$keys['key2'] = $this->getCutKeyValue($k2);
			if (is_array($v2)) {	
				foreach ($v2 as $k3 => $v3) {
					$keys['key3'] = $this->getCutKeyValue($k3);
					if (is_array($v3)) {
						foreach ($v3 as $k4 => $v4) {
							$keys['key4'] = $this->getCutKeyValue($k4);
							$id = $valsModel->insertValueId($keyId, $keys, is_array($v4) ? $this->getCutTextValue(json_encode($v4), false) : $this->getCutTextValue($v4));
							if ($id) {
								$insert .= $queryValue . $id . '),';
							}
						}
					} else {
						$id = $valsModel->insertValueId($keyId, $keys, $this->getCutTextValue($v3));
						if ($id) {
							$insert .= $queryValue . $id . '),';
						}
					}
				}
			} else {
				$id = $valsModel->insertValueId($keyId, $keys, $this->getCutTextValue($v2));
				if ($id) {
					$insert .= $queryValue . $id . '),';
				}
			}

		}

		return $insert;
	}

	public function saveMetaList( $keyId, $productId, $isVar, $data ) {
		$insert = '';
		$queryValue = '(' . $productId . ',' . $isVar . ',' . $keyId . ',';
		$keys = $this->keysArray;
		$valsModel = $this->valsModel;
		foreach ($data as $k => $v) {
			$id = $valsModel->insertValueId($keyId, $keys, is_array($v) ? $this->getCutTextValue(json_encode($v), false) : $this->getCutTextValue($v));
			if ($id) {
				$insert .= $queryValue . $id . '),';
			}
		}
		return $insert;
	}
	
	public function saveMetaArray_product_attributes( $keyId, $productId, $isVar, $data ) {
		$insert = '';
		$queryValue = '(' . $productId . ',' . $isVar . ',' . $keyId . ',';
		$keys = $this->keysArray;
		$valsModel = $this->valsModel;
		foreach ($data as $k2 => $v2) {
			$keys['key3'] = $this->getCutKeyValue($k2);
			$keys['key2'] = 'is_variation';
			$id = $valsModel->insertValueId($keyId, $keys, ( isset($v2['is_variation']) && '1' == $v2['is_variation'] ? 1 : 0 ));
			if ($id) {
				$insert .= $queryValue . $id . '),';
			} else {
				$this->pushError($valsModel->getErrors());
				return false;
			}

			if (is_array($v2) && isset($v2['is_taxonomy']) && ( '1' != $v2['is_taxonomy'] ) && !empty($v2['value'])) {
				//$keys['key2'] = $this->getCutKeyValue($k2);
				$values = explode('|', $v2['value']);
				$keys['key2'] = 'local';
				foreach ($values as $value) {
					$value = trim($value);
					if (!empty($value)) {
						$id = $valsModel->insertValueId($keyId, $keys, $this->getCutTextValue($value));
						if ($id) {
							$insert .= $queryValue . $id . '),';
						} else {
							$this->pushError($valsModel->getErrors());
							return false;
						}
					}
				}
			}
		}
		return $insert;
	}


	public function getCutTextValue( $str, $cut = true ) {
		if ($this->existMB) {
			if (mb_strlen($str) > $this->maxTextLength) {
				return $cut ? mb_substr($str, 0, $this->maxTextLength) : '';
			}
		} else {
			if (strlen($str) > $this->maxTextLength) {
				return $cut ? substr($str, 0, $this->maxTextLength) : '';
			}
		}
		return $str;
	}
	public function getCutKeyValue( $str, $cut = true ) {
		if ($this->existMB) {
			if (mb_strlen($str) > $this->maxKeyLength) {
				return $cut ? mb_substr($str, 0, $this->maxKeyLength) : '';
			}
		} else {
			if (strlen($str) > $this->maxKeyLength) {
				return $cut ? substr($str, 0, $this->maxKeyLength) : '';
			}
		}
		return $str;
	}

	public function saveMeta_wpf_product_type( $productId, $keyData, $tempTable ) {
		$keyId = $keyData['id'];
		$keys = array();
		for ($k = $this->maxKeySize; $k >= 2; $k--) {
			$keys['key' . $k] = '';
		}

		$values = array_flip($this->valsModel->getKeyValueIds($keyId, $keys, true));

		$avariable = array('variable', 'single', 'variation');
		foreach ($avariable as $value) {	
			if (!isset($values[$value])) {
				$keys['key_id'] = $keyId;
				$keys['value'] = $value;
				$values[$value] = $this->valsModel->insert($keys);
				if (!$values[$value]) {
					return false;
				}
			}
		}

		$query = 'INSERT INTO @__meta_data (product_id, is_var, key_id, val_id)' .
			' SELECT DISTINCT p.id, ' . ( $tempTable ? 'p.is_var,' : "IF(p.post_type='product_variation',1,0) as is_var," ) . $keyId . ',' . 
			' CASE WHEN p.post_parent>0 THEN ' . $values['variation'] .
			" WHEN EXISTS(SELECT 1 FROM `#__posts` as pa WHERE pa.post_parent=p.ID AND pa.post_type='product_variation' LIMIT 1) THEN " . $values['variable'] . ' ELSE ' . $values['single'] . ' END' .
			' FROM ' . ( $tempTable ? $tempTable : ' `#__posts` ' ) . ' as p' .
			' WHERE ' . ( $tempTable ? '1=1' : " p.post_type IN ('product','product_variation') AND p.post_status IN('publish')" ) . ( empty($productId) ? '' : ' AND p.id=' . $productId );

		if (!DbWpf::query($query)) {
			$this->pushError(DbWpf::getError());
			return false;
		}
		return true;
	}

	
}

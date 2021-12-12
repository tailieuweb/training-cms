<?php

namespace VisualComposer\Modules\Editors\Templates;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Framework\Container;
use VisualComposer\Helpers\Access\CurrentUser;
use VisualComposer\Helpers\EditorTemplates;
use VisualComposer\Helpers\Frontend;
use VisualComposer\Helpers\Options;
use VisualComposer\Helpers\PostType;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Traits\WpFiltersActions;

/**
 * Class Controller.
 */
class Controller extends Container implements Module
{
    use EventsFilters;
    use WpFiltersActions;

    public function __construct()
    {
        /** @see \VisualComposer\Modules\Editors\Templates\Controller::allTemplatesAsync */
        $this->addFilter('vcv:dataAjax:getData', 'allTemplatesAsync');

        /** @see \VisualComposer\Modules\Editors\Templates\Controller::read */
        $this->addFilter('vcv:ajax:editorTemplates:read:adminNonce', 'read');

        /** @see \VisualComposer\Modules\Editors\Templates\Controller::delete */
        $this->addFilter('vcv:ajax:editorTemplates:delete:adminNonce', 'delete');

        /** @see \VisualComposer\Modules\Editors\Templates\Controller::saveTemplateId */
        $this->addFilter('vcv:dataAjax:setData:sourceId', 'saveTemplateId');

        /** @see \VisualComposer\Modules\Editors\Templates\Controller::saveTemplateId */
        $this->addFilter('vcv:dataAjax:setData', 'setDataResponse');

        /** @see \VisualComposer\Modules\Editors\Templates\Controller::setCurrentTemplateLayoutBlank */
        $this->addFilter('vcv:editor:settings:pageTemplatesLayouts:current', 'setCurrentTemplateLayoutBlank', 30);

        $this->wpAddFilter('wp_untrash_post_status', 'untrashTemplate', 30);

        // In case if Trashed template removed
        $this->wpAddAction('before_delete_post', 'deleteTemplateData');

        $this->wpAddFilter('save_post_vcv_templates', 'clearCache');
    }

    /**
     * The Template editors should have always "blank" behaviour
     *
     * @param $originalTemplate
     * @param \VisualComposer\Helpers\PostType $postTypeHelper
     * @param \VisualComposer\Helpers\Frontend $frontendHelper
     * @param \VisualComposer\Helpers\Request $requestHelper
     *
     * @return array
     */
    protected function setCurrentTemplateLayoutBlank(
        $originalTemplate,
        PostType $postTypeHelper,
        Frontend $frontendHelper,
        Request $requestHelper
    ) {
        if (
            ($requestHelper->input('vcv-editor-type') === 'vcv_templates' && $frontendHelper->isFrontend())
            || $frontendHelper->isPageEditable()
        ) {
            $postId = vcfilter('vcv:editor:settings:pageTemplatesLayouts:current:custom');
            if ($postTypeHelper->get($postId)->post_type === 'vcv_templates') {
                return ['type' => 'vc', 'value' => 'blank', 'stretchedContent' => 1];
            }
        }

        return $originalTemplate;
    }

    /**
     * @param $response
     * @param \VisualComposer\Helpers\EditorTemplates $editorTemplatesHelper
     *
     * @return array
     */
    protected function allTemplatesAsync($response, EditorTemplates $editorTemplatesHelper)
    {
        // TODO: Optimize, use pagination via ajax don't "all" output instantly
        // TODO: consider preload only 5 templates, the rest only via ajax/pagination VC-1904
        if (!vcIsBadResponse($response)) {
            $templates = $editorTemplatesHelper->all();
            $response['templates'] = $templates;
            $groups = [];
            foreach ($templates as $templateData) {
                $groups[] = $templateData['type'];
            }
            // User-made templates goes first
            usort(
                $groups,
                function ($typeA, $typeB) {
                    $cmpA = strpos($typeA, 'custom');
                    $cmpB = strpos($typeB, 'custom');
                    $cmpA = $cmpA !== false ? -1 * abs(20 - strlen($typeA)) : strlen($typeA);
                    $cmpB = $cmpB !== false ? -1 * abs(20 - strlen($typeB)) : strlen($typeB);

                    return $cmpA - $cmpB;
                }
            );
            $response['templatesGroupsSorted'] = $groups;
        }

        return $response;
    }

    /**
     * @param $type
     * @param \VisualComposer\Helpers\Access\CurrentUser $currentUserAccessHelper
     * @param \VisualComposer\Helpers\EditorTemplates $editorTemplatesHelper
     *
     * @return bool|integer
     */
    protected function create(
        $type,
        CurrentUser $currentUserAccessHelper,
        EditorTemplates $editorTemplatesHelper
    ) {
        $haveAccess = $currentUserAccessHelper->wpAll('edit_posts')->get();
        if (vcvenv('VCV_ADDON_ROLE_MANAGER_ENABLED')) {
            $haveAccess = $currentUserAccessHelper->part('editor_content')->can('user_templates_management')->get();
        }
        if ($haveAccess) {
            $templateId = $editorTemplatesHelper->create($type);
            if ($templateId) {
                return $templateId;
            }
        }

        return false;
    }

    /**
     * @CRUD
     *
     * @param \VisualComposer\Helpers\Request $requestHelper
     * @param \VisualComposer\Helpers\PostType $postTypeHelper
     *
     * @return array
     */
    protected function delete(
        Request $requestHelper,
        PostType $postTypeHelper
    ) {
        $id = (int)$requestHelper->input('vcv-template-id');
        $template = $postTypeHelper->get($id, 'vcv_templates');
        $status = false;
        if ($template) {
            $status = $postTypeHelper->trash($id, 'vcv_templates');
        }

        return [
            'status' => $status,
            'message' => !$status ? __('You are not allowed to delete templates.', 'visualcomposer') : '',
        ];
    }

    protected function deleteTemplateData(
        $sourceId,
        PostType $postTypeHelper,
        EditorTemplates $editorTemplatesHelper,
        Options $optionsHelper
    ) {
        $template = $postTypeHelper->get($sourceId, 'vcv_templates');
        if ($template) {
            $templateType = get_post_meta($sourceId, '_vcv-type', true);
            if (!$editorTemplatesHelper->isUserTemplateType($templateType)) {
                // @codingStandardsIgnoreLine
                $templateSlug = vchelper('Str')->camel($template->post_title);
                $optionsHelper->delete('hubAction:template/' . $templateSlug);
                if ($templateType === 'predefined') {
                    $optionsHelper->delete('hubAction:predefinedTemplate/' . $templateSlug);
                }
            }
        }
    }

    protected function untrashTemplate($status, $sourceId, PostType $postTypeHelper)
    {
        $template = $postTypeHelper->get($sourceId, 'vcv_templates');
        if ($template) {
            return 'publish';
        }

        return $status;
    }

    /**
     * CRUD -> read
     *
     * @param \VisualComposer\Helpers\Request $requestHelper
     * @param \VisualComposer\Helpers\EditorTemplates $editorTemplatesHelper
     * @param \VisualComposer\Helpers\Access\CurrentUser $currentUserHelper
     *
     * @return array|bool
     */
    protected function read(
        Request $requestHelper,
        EditorTemplates $editorTemplatesHelper,
        CurrentUser $currentUserHelper
    ) {
        $id = $requestHelper->input('vcv-template-id');
        if ($currentUserHelper->wpAll(['read_post', $id])) {
            $template = $editorTemplatesHelper->read($id);
            if ($template) {
                $optionsHelper = vchelper('Options');
                // Most used count updates
                vcfilter(
                    'vcv:ajax:usageCount:updateUsage:adminNonce',
                    [],
                    ['tag' => 'template/' . $id]
                );
                // Data usage statistics
                $isAllowed = $optionsHelper->get('settings-itemdatacollection-enabled', false);
                if ($isAllowed) {
                    $sourceId = $requestHelper->input('vcv-source-id');
                    vcevent(
                        'vcv:saveTemplateUsage',
                        ['response' => [], 'payload' => ['sourceId' => $sourceId, 'templateId' => $id]]
                    );
                }

                return $template;
            }
        }

        return ['status' => false];
    }

    /**
     * @param $sourceId
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \VisualComposer\Framework\Illuminate\Container\BindingResolutionException
     */
    protected function saveTemplateId($sourceId)
    {
        if (in_array($sourceId, ['template', 'customBlock'])) {
            /** @see \VisualComposer\Modules\Editors\Templates\Controller::create */
            $type = vcfilter(
                'vcv:editorTemplates:template:type',
                $sourceId === 'template' ? 'custom' : 'customBlock',
                [
                    'sourceId' => $sourceId,
                ]
            );
            $templateId = $this->call('create', ['type' => $type]);
            if ($templateId) {
                // Create template ID
                if (!get_post_meta($sourceId, '_' . VCV_PREFIX . 'id', true)) {
                    update_post_meta($sourceId, '_' . VCV_PREFIX . 'id', uniqid('', true));
                }

                return [
                    'status' => true,
                    'sourceId' => $templateId,
                    'accessCheck' => false,
                    // we already checked for access: skip ->canEdit check in DataAjax/Controller
                ];
            }

            return ['status' => false];
        }

        return $sourceId;
    }

    protected function setDataResponse($response, $payload, EditorTemplates $editorTemplatesHelper)
    {
        if (
            isset($payload['sourceId'])
            && is_numeric($payload['sourceId'])
            && get_post_type($payload['sourceId']) === 'vcv_templates'
        ) {
            $type = get_post_meta($payload['sourceId'], '_' . VCV_PREFIX . 'type', true);
            $response['templateGroup'] = [
                'type' => $type,
                'name' => $editorTemplatesHelper->getGroupName($type),
            ];
        }

        return $response;
    }

    protected function clearCache()
    {
        wp_cache_delete('vcv:helpers:templates:all', 'vcwb');
    }
}

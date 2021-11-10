-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 10, 2021 at 03:30 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress_581`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp581_commentmeta`
--

CREATE TABLE `wp581_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp581_comments`
--

CREATE TABLE `wp581_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_comments`
--

INSERT INTO `wp581_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'A WordPress Commenter', 'wapuu@wordpress.example', 'https://wordpress.org/', '', '2021-09-30 22:59:54', '2021-09-30 22:59:54', 'Hi, this is a comment.\r\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\r\nCommenter avatars come from <a href=\"https://gravatar.com\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp581_links`
--

CREATE TABLE `wp581_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp581_options`
--

CREATE TABLE `wp581_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_options`
--

INSERT INTO `wp581_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://wordpress.local:90/', 'yes'),
(2, 'home', 'http://wordpress.local:90/', 'yes'),
(3, 'blogname', 'Group A', 'yes'),
(4, 'blogdescription', '', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'tailieuweb.com@gmail.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:96:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:0:{}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'twentytwenty', 'yes'),
(41, 'stylesheet', 'twentytwenty', 'yes'),
(42, 'comment_registration', '0', 'yes'),
(43, 'html_type', 'text/html', 'yes'),
(44, 'use_trackback', '0', 'yes'),
(45, 'default_role', 'subscriber', 'yes'),
(46, 'db_version', '49752', 'yes'),
(47, 'uploads_use_yearmonth_folders', '1', 'yes'),
(48, 'upload_path', '', 'yes'),
(49, 'blog_public', '1', 'yes'),
(50, 'default_link_category', '2', 'yes'),
(51, 'show_on_front', 'posts', 'yes'),
(52, 'tag_base', '', 'yes'),
(53, 'show_avatars', '1', 'yes'),
(54, 'avatar_rating', 'G', 'yes'),
(55, 'upload_url_path', '', 'yes'),
(56, 'thumbnail_size_w', '150', 'yes'),
(57, 'thumbnail_size_h', '150', 'yes'),
(58, 'thumbnail_crop', '1', 'yes'),
(59, 'medium_size_w', '300', 'yes'),
(60, 'medium_size_h', '300', 'yes'),
(61, 'avatar_default', 'mystery', 'yes'),
(62, 'large_size_w', '1024', 'yes'),
(63, 'large_size_h', '1024', 'yes'),
(64, 'image_default_link_type', 'none', 'yes'),
(65, 'image_default_size', '', 'yes'),
(66, 'image_default_align', '', 'yes'),
(67, 'close_comments_for_old_posts', '0', 'yes'),
(68, 'close_comments_days_old', '14', 'yes'),
(69, 'thread_comments', '1', 'yes'),
(70, 'thread_comments_depth', '5', 'yes'),
(71, 'page_comments', '0', 'yes'),
(72, 'comments_per_page', '50', 'yes'),
(73, 'default_comments_page', 'newest', 'yes'),
(74, 'comment_order', 'asc', 'yes'),
(75, 'sticky_posts', 'a:0:{}', 'yes'),
(76, 'widget_categories', 'a:0:{}', 'yes'),
(77, 'widget_text', 'a:0:{}', 'yes'),
(78, 'widget_rss', 'a:0:{}', 'yes'),
(79, 'uninstall_plugins', 'a:0:{}', 'no'),
(80, 'timezone_string', '', 'yes'),
(81, 'page_for_posts', '0', 'yes'),
(82, 'page_on_front', '0', 'yes'),
(83, 'default_post_format', '0', 'yes'),
(84, 'link_manager_enabled', '0', 'yes'),
(85, 'finished_splitting_shared_terms', '1', 'yes'),
(86, 'site_icon', '0', 'yes'),
(87, 'medium_large_size_w', '768', 'yes'),
(88, 'medium_large_size_h', '0', 'yes'),
(89, 'wp_page_for_privacy_policy', '3', 'yes'),
(90, 'show_comments_cookies_opt_in', '1', 'yes'),
(91, 'admin_email_lifespan', '1648594794', 'yes'),
(92, 'disallowed_keys', '', 'no'),
(93, 'comment_previously_approved', '1', 'yes'),
(94, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
(95, 'auto_update_core_dev', 'enabled', 'yes'),
(96, 'auto_update_core_minor', 'enabled', 'yes'),
(97, 'auto_update_core_major', 'enabled', 'yes'),
(98, 'wp_force_deactivated_plugins', 'a:0:{}', 'yes'),
(99, 'initial_db_version', '49752', 'yes'),
(100, 'wp581_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(101, 'fresh_site', '0', 'yes'),
(102, 'widget_block', 'a:6:{i:3;a:1:{s:7:\"content\";s:160:\"<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:heading -->\n<h2>Recent Posts</h2>\n<!-- /wp:heading -->\n\n<!-- wp:latest-posts /--></div>\n<!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:233:\"<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:heading -->\n<h2>Recent Comments</h2>\n<!-- /wp:heading -->\n\n<!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div>\n<!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}i:7;a:1:{s:7:\"content\";s:665:\"<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:heading -->\n<h2>About</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>WordPress là một hệ thống mã nguồn mở dùng để xuất bản blog/website được viết bằng ngôn ngữ lập trình PHP và cơ sở dữ liệu MySQL. WordPress được biết đến như một CMS miễn phí nhưng tốt, dễ sử dụng và phổ biến nhất trên thế giới. Với WordPress, bạn có thể tạo trang web thương mại điện tử, cổng thông tin, portfolio online, diễn đàn thảo luận và những web tuyệt vời khác.</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'sidebars_widgets', 'a:5:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:2:{i:0;s:7:\"block-3\";i:1;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}s:9:\"sidebar-3\";a:1:{i:0;s:7:\"block-7\";}s:13:\"array_version\";i:3;}', 'yes'),
(104, 'cron', 'a:6:{i:1636556395;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1636585195;a:5:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:18:\"wp_https_detection\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1636586219;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1636586282;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1636757995;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(105, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(113, 'widget_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(114, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(115, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(116, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(118, 'recovery_keys', 'a:0:{}', 'yes'),
(119, 'https_detection_errors', 'a:1:{s:20:\"https_request_failed\";a:1:{i:0;s:21:\"HTTPS request failed.\";}}', 'yes'),
(120, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.8.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.8.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.8.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.8.1-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"5.8.1\";s:7:\"version\";s:5:\"5.8.1\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.6\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1636544506;s:15:\"version_checked\";s:5:\"5.8.1\";s:12:\"translations\";a:0:{}}', 'no'),
(121, 'theme_mods_twentytwentyone', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1633044767;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}', 'yes'),
(126, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1636544505;s:7:\"checked\";a:3:{s:14:\"twentynineteen\";s:3:\"2.1\";s:12:\"twentytwenty\";s:3:\"1.8\";s:15:\"twentytwentyone\";s:3:\"1.4\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:3:{s:14:\"twentynineteen\";a:6:{s:5:\"theme\";s:14:\"twentynineteen\";s:11:\"new_version\";s:3:\"2.1\";s:3:\"url\";s:44:\"https://wordpress.org/themes/twentynineteen/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/twentynineteen.2.1.zip\";s:8:\"requires\";s:5:\"4.9.6\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:12:\"twentytwenty\";a:6:{s:5:\"theme\";s:12:\"twentytwenty\";s:11:\"new_version\";s:3:\"1.8\";s:3:\"url\";s:42:\"https://wordpress.org/themes/twentytwenty/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/theme/twentytwenty.1.8.zip\";s:8:\"requires\";s:3:\"4.7\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:15:\"twentytwentyone\";a:6:{s:5:\"theme\";s:15:\"twentytwentyone\";s:11:\"new_version\";s:3:\"1.4\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentyone/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentyone.1.4.zip\";s:8:\"requires\";s:3:\"5.3\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}', 'no'),
(131, 'finished_updating_comment_type', '1', 'yes'),
(132, 'can_compress_scripts', '1', 'no'),
(137, 'category_children', 'a:0:{}', 'yes'),
(152, 'current_theme', 'Twenty Twenty', 'yes'),
(153, 'theme_mods_twentytwenty', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:5:{s:7:\"primary\";i:7;s:8:\"expanded\";i:7;s:6:\"mobile\";i:7;s:6:\"footer\";i:7;s:6:\"social\";i:7;}s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(154, 'theme_switched', '', 'yes'),
(162, '_transient_health-check-site-status-result', '{\"good\":13,\"recommended\":5,\"critical\":1}', 'yes'),
(179, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:\"auto_add\";a:1:{i:1;i:7;}}', 'yes'),
(182, 'WPLANG', '', 'yes'),
(183, 'new_admin_email', 'tailieuweb.com@gmail.com', 'yes'),
(219, '_site_transient_timeout_php_check_26328e95a1a09d326a615e4b43668741', '1636602767', 'no'),
(220, '_site_transient_php_check_26328e95a1a09d326a615e4b43668741', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"5.6.20\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'no'),
(240, '_site_transient_timeout_browser_4442faaaa82a74b0037a8d68bbfb65d2', '1637075752', 'no'),
(241, '_site_transient_browser_4442faaaa82a74b0037a8d68bbfb65d2', 'a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:13:\"93.0.4577.100\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}', 'no'),
(266, '_site_transient_timeout_theme_roots', '1636546304', 'no'),
(267, '_site_transient_theme_roots', 'a:3:{s:14:\"twentynineteen\";s:7:\"/themes\";s:12:\"twentytwenty\";s:7:\"/themes\";s:15:\"twentytwentyone\";s:7:\"/themes\";}', 'no'),
(269, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1636544509;s:8:\"response\";a:1:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.2.1\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.2.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";s:6:\"tested\";s:5:\"5.8.1\";s:12:\"requires_php\";b:0;}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:1:{s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}}s:7:\"checked\";a:2:{s:19:\"akismet/akismet.php\";s:6:\"4.1.12\";s:9:\"hello.php\";s:5:\"1.7.2\";}}', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `wp581_postmeta`
--

CREATE TABLE `wp581_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_postmeta`
--

INSERT INTO `wp581_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(3, 4, '_edit_lock', '1633043781:1'),
(6, 6, '_edit_lock', '1633043826:1'),
(11, 8, '_edit_lock', '1633043848:1'),
(14, 10, '_edit_lock', '1633043871:1'),
(17, 12, '_edit_lock', '1633043902:1'),
(20, 14, '_edit_lock', '1633043947:1'),
(23, 16, '_edit_lock', '1633043984:1'),
(26, 18, '_edit_lock', '1633044009:1'),
(47, 23, '_menu_item_type', 'taxonomy'),
(48, 23, '_menu_item_menu_item_parent', '0'),
(49, 23, '_menu_item_object_id', '2'),
(50, 23, '_menu_item_object', 'category'),
(51, 23, '_menu_item_target', ''),
(52, 23, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(53, 23, '_menu_item_xfn', ''),
(54, 23, '_menu_item_url', ''),
(56, 24, '_menu_item_type', 'taxonomy'),
(57, 24, '_menu_item_menu_item_parent', '0'),
(58, 24, '_menu_item_object_id', '4'),
(59, 24, '_menu_item_object', 'category'),
(60, 24, '_menu_item_target', ''),
(61, 24, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(62, 24, '_menu_item_xfn', ''),
(63, 24, '_menu_item_url', '');

-- --------------------------------------------------------

--
-- Table structure for table `wp581_posts`
--

CREATE TABLE `wp581_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_posts`
--

INSERT INTO `wp581_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2021-09-30 22:59:54', '2021-09-30 22:59:54', '<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2021-09-30 22:59:54', '2021-09-30 22:59:54', '', 0, 'http://wordpress.local/?p=1', 0, 'post', '', 1),
(2, 1, '2021-09-30 22:59:54', '2021-09-30 22:59:54', '<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://wordpress.local/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2021-09-30 22:59:54', '2021-09-30 22:59:54', '', 0, 'http://wordpress.local/?page_id=2', 0, 'page', '', 0),
(3, 1, '2021-09-30 22:59:54', '2021-09-30 22:59:54', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://wordpress.local.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Comments</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Media</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Embedded content from other websites</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2021-09-30 22:59:54', '2021-09-30 22:59:54', '', 0, 'http://wordpress.local/?page_id=3', 0, 'page', '', 0),
(4, 1, '2021-09-30 23:18:43', '2021-09-30 23:18:43', '<!-- wp:paragraph -->\n<p>Harry Kane vào thay người và rồi ghi liền ba bàn trong 30 phút cuối trận, giúp Tottenham hạ Mura 5-1 ở lượt hai Conference League hôm 30/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><a href=\"https://vnexpress.net/chu-de/harry-kane-239\">Kane</a>&nbsp;là một trong ba cầu thủ vào sân cùng lúc từ phút 59, bên cạnh&nbsp;<a href=\"https://vnexpress.net/chu-de/son-heung-min-395\">Son Heung-min</a>&nbsp;và Lucas Moura. Khi đó, Mura mới rút ngắn tỷ số còn 1-2 và đang chơi tốt lên. HLV Nuno Espirito Santo nhận thấy rủi ro, nên tung cùng lúc ba tiền đạo chủ lực vào sân, để giải quyết trận đấu. Và đó là quyết định đúng, khi Kane ghi liền ba bàn, trong đó có hai bàn đầu đến từ các pha phối hợp với Moura rồi Son.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Phút 68, Moura thoát xuống bên cánh phải, rồi chuyền bóng ra phía sau hàng thủ Mura. Dù bị trượt chân và hơi với, Kane vẫn kịp chạm bóng vừa đủ hạ thủ môn CLB Slovenia - người băng ra rất sớm để ngăn cú dứt điểm, nhưng bất thành. 11 phút sau đó, Kane lại ghi bàn, với cú đệm cận thành sau đường dọn cỗ của Son.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/Kane-AP-jpeg-1442-1633038285.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=g5cwSU2Z3Pj62xdTOYDmZg\" alt=\"Kane trong bàn nâng tỷ số lên 3-1 cho Tottenham trong trận thắng Mura 5-1 tại London hôm 30/9. Ảnh: AP\"/><figcaption>Kane trong bàn nâng tỷ số lên 3-1 cho Tottenham trong trận thắng Mura 5-1 tại London hôm 30/9. Ảnh:&nbsp;<em>AP</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Tới phút 88, Lo Celso - một trong những ngôi sao hiếm hoi được đá chính - đưa bóng từ phải vào rồi chuyền cho Kane. Dù bị kẹp giữa hai hậu vệ Mura, số 10 của Tottenham vẫn chạm bóng một nhịp rồi quăng chân, lái bóng về góc thấp phía xa, ấn định thắng lợi 5-1.</p>\n<!-- /wp:paragraph -->', 'Kane ghi hattrick ở Cup châu Âu', '', 'publish', 'open', 'open', '', 'kane-ghi-hattrick-o-cup-chau-au', '', '', '2021-09-30 23:18:43', '2021-09-30 23:18:43', '', 0, 'http://wordpress.local/?p=4', 0, 'post', '', 0),
(5, 1, '2021-09-30 23:18:43', '2021-09-30 23:18:43', '<!-- wp:paragraph -->\n<p>Harry Kane vào thay người và rồi ghi liền ba bàn trong 30 phút cuối trận, giúp Tottenham hạ Mura 5-1 ở lượt hai Conference League hôm 30/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><a href=\"https://vnexpress.net/chu-de/harry-kane-239\">Kane</a>&nbsp;là một trong ba cầu thủ vào sân cùng lúc từ phút 59, bên cạnh&nbsp;<a href=\"https://vnexpress.net/chu-de/son-heung-min-395\">Son Heung-min</a>&nbsp;và Lucas Moura. Khi đó, Mura mới rút ngắn tỷ số còn 1-2 và đang chơi tốt lên. HLV Nuno Espirito Santo nhận thấy rủi ro, nên tung cùng lúc ba tiền đạo chủ lực vào sân, để giải quyết trận đấu. Và đó là quyết định đúng, khi Kane ghi liền ba bàn, trong đó có hai bàn đầu đến từ các pha phối hợp với Moura rồi Son.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Phút 68, Moura thoát xuống bên cánh phải, rồi chuyền bóng ra phía sau hàng thủ Mura. Dù bị trượt chân và hơi với, Kane vẫn kịp chạm bóng vừa đủ hạ thủ môn CLB Slovenia - người băng ra rất sớm để ngăn cú dứt điểm, nhưng bất thành. 11 phút sau đó, Kane lại ghi bàn, với cú đệm cận thành sau đường dọn cỗ của Son.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/Kane-AP-jpeg-1442-1633038285.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=g5cwSU2Z3Pj62xdTOYDmZg\" alt=\"Kane trong bàn nâng tỷ số lên 3-1 cho Tottenham trong trận thắng Mura 5-1 tại London hôm 30/9. Ảnh: AP\"/><figcaption>Kane trong bàn nâng tỷ số lên 3-1 cho Tottenham trong trận thắng Mura 5-1 tại London hôm 30/9. Ảnh:&nbsp;<em>AP</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Tới phút 88, Lo Celso - một trong những ngôi sao hiếm hoi được đá chính - đưa bóng từ phải vào rồi chuyền cho Kane. Dù bị kẹp giữa hai hậu vệ Mura, số 10 của Tottenham vẫn chạm bóng một nhịp rồi quăng chân, lái bóng về góc thấp phía xa, ấn định thắng lợi 5-1.</p>\n<!-- /wp:paragraph -->', 'Kane ghi hattrick ở Cup châu Âu', '', 'inherit', 'closed', 'closed', '', '4-revision-v1', '', '', '2021-09-30 23:18:43', '2021-09-30 23:18:43', '', 4, 'http://wordpress.local/?p=5', 0, 'revision', '', 0),
(6, 1, '2021-09-30 23:19:07', '2021-09-30 23:19:07', '<!-- wp:paragraph -->\n<p>Theo HLV Antonio Conte, nếu phát huy được hết khả năng của Romelu Lukaku, Chelsea có thể đánh bại mọi đối thủ ở Champions League.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"HLV giỏi là người biết nâng tầm các cầu thủ. Khi sở hữu một trung phong cắm như Lukaku, bạn cần phải tận dụng tối đa. Và tôi nghĩ Chelsea chưa tìm ra cách sử dụng cậu ấy hiệu quả nhất\",&nbsp;<a href=\"https://vnexpress.net/chu-de/antonio-conte-172\">Conte</a>&nbsp;nói trên&nbsp;<em>Sky Sport Italy</em>&nbsp;hôm 29/9. \"Chelsea không có tiền đạo cắm đúng nghĩa mùa trước, và thường xuyên xoay vòng. Giờ thì họ không cần làm như thế nữa khi đã có Lukaku. Nếu Tuchel phát huy hết khả năng của Lukaku, Chelsea có thể đánh bại mọi đối thủ ở Champions League mùa này\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/30/2317-jpeg-2170-1633015096.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=f9qZH_hwat-i1vuQjJywXg\" alt=\"Lukaku buồn bã sau khi cùng Chelsea thua 0-1 trên sân Juventus hôm 29/9. Ảnh: PA\"/><figcaption>Lukaku buồn bã sau khi cùng Chelsea thua 0-1 trên sân Juventus hôm 29/9. Ảnh:&nbsp;<em>PA</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Sau hai năm không thành công tại&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/man-utd-33\">Man Utd</a>, Lukaku lột xác khi gia nhập&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/inter-505\">Inter</a>&nbsp;thi đấu dưới trướng Conte. Tại đây, tiền đạo người Bỉ ghi 64 bàn cùng 16 kiến tạo sau 95 trận trên mọi đấu trường. Mùa trước, anh ghi 24 bàn và 11 kiến tạo, góp công lớn giúp Inter đoạt scudetto, chấm dứt chín năm thống trị của Juventus ở Serie A.</p>\n<!-- /wp:paragraph -->', 'Conte chê Tuchel không biết dùng Lukaku', '', 'publish', 'open', 'open', '', 'conte-che-tuchel-khong-biet-dung-lukaku', '', '', '2021-09-30 23:19:29', '2021-09-30 23:19:29', '', 0, 'http://wordpress.local/?p=6', 0, 'post', '', 0),
(7, 1, '2021-09-30 23:19:07', '2021-09-30 23:19:07', '<!-- wp:paragraph -->\n<p>Theo HLV Antonio Conte, nếu phát huy được hết khả năng của Romelu Lukaku, Chelsea có thể đánh bại mọi đối thủ ở Champions League.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"HLV giỏi là người biết nâng tầm các cầu thủ. Khi sở hữu một trung phong cắm như Lukaku, bạn cần phải tận dụng tối đa. Và tôi nghĩ Chelsea chưa tìm ra cách sử dụng cậu ấy hiệu quả nhất\",&nbsp;<a href=\"https://vnexpress.net/chu-de/antonio-conte-172\">Conte</a>&nbsp;nói trên&nbsp;<em>Sky Sport Italy</em>&nbsp;hôm 29/9. \"Chelsea không có tiền đạo cắm đúng nghĩa mùa trước, và thường xuyên xoay vòng. Giờ thì họ không cần làm như thế nữa khi đã có Lukaku. Nếu Tuchel phát huy hết khả năng của Lukaku, Chelsea có thể đánh bại mọi đối thủ ở Champions League mùa này\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/30/2317-jpeg-2170-1633015096.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=f9qZH_hwat-i1vuQjJywXg\" alt=\"Lukaku buồn bã sau khi cùng Chelsea thua 0-1 trên sân Juventus hôm 29/9. Ảnh: PA\"/><figcaption>Lukaku buồn bã sau khi cùng Chelsea thua 0-1 trên sân Juventus hôm 29/9. Ảnh:&nbsp;<em>PA</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Sau hai năm không thành công tại&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/man-utd-33\">Man Utd</a>, Lukaku lột xác khi gia nhập&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/inter-505\">Inter</a>&nbsp;thi đấu dưới trướng Conte. Tại đây, tiền đạo người Bỉ ghi 64 bàn cùng 16 kiến tạo sau 95 trận trên mọi đấu trường. Mùa trước, anh ghi 24 bàn và 11 kiến tạo, góp công lớn giúp Inter đoạt scudetto, chấm dứt chín năm thống trị của Juventus ở Serie A.</p>\n<!-- /wp:paragraph -->', 'Conte chê Tuchel không biết dùng Lukaku', '', 'inherit', 'closed', 'closed', '', '6-revision-v1', '', '', '2021-09-30 23:19:07', '2021-09-30 23:19:07', '', 6, 'http://wordpress.local/?p=7', 0, 'revision', '', 0),
(8, 1, '2021-09-30 23:19:50', '2021-09-30 23:19:50', '<!-- wp:paragraph -->\n<p>Lionel Messi vượt qua ba đề cử khác để nhận giải \"Bàn thắng đẹp nhất lượt đấu Champions League\" cho pha ấn định tỷ số 2-0 trước Man City.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Sáng 30/9, UEFA chọn ra bốn đề cử bàn thắng đẹp gồm bàn đầu tay của&nbsp;<a href=\"https://vnexpress.net/chu-de/lionel-messi-300\">Messi</a>&nbsp;(PSG), cú vuốt bóng của Alex Telles (Man Utd) vào lưới Villarreal, pha vẩy má ngoài của Sebastian Thill (Sheriff) trước&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/real-madrid-541\">Real Madrid</a>&nbsp;và quả vô-lê của Antoine Griezmann (Atletico Madrid) tung lưới Milan.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/30/messi-jpeg-7737-1633016248.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=Kd66JZaYYIO9wjcg0ujbfA\" alt=\"Bàn đầu tiên của Messi cho PSG được chọn là tuyệt phẩm lượt đấu thứ hai của vòng bảng Champions League. Ảnh: Reuters\"/><figcaption>Bàn đầu tiên của Messi cho PSG được chọn là tuyệt phẩm lượt đấu thứ hai của vòng bảng Champions League. Ảnh:&nbsp;<em>Reuters</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Sau 12 tiếng nhận bình chọn từ độc giả trên trang chủ, UEFA công bố tuyệt phẩm của Messi nhận được nhiều phiếu bầu nhất. Thill đứng thứ hai với bàn thắng quyết định giúp Sheriff thắng Real 2-1 ngay tại Bernabeu ở phút 90. Telles về ba với cú vuốt bóng gỡ hoà 1-1 cho Man Utd. Còn Griezmann đứng cuối cũng với bàn gỡ hoà cho Atletico Madrid.</p>\n<!-- /wp:paragraph -->', 'Messi ghi bàn đẹp nhất lượt hai Champions League', '', 'publish', 'open', 'open', '', 'messi-ghi-ban-dep-nhat-luot-hai-champions-league', '', '', '2021-09-30 23:19:50', '2021-09-30 23:19:50', '', 0, 'http://wordpress.local/?p=8', 0, 'post', '', 0),
(9, 1, '2021-09-30 23:19:50', '2021-09-30 23:19:50', '<!-- wp:paragraph -->\n<p>Lionel Messi vượt qua ba đề cử khác để nhận giải \"Bàn thắng đẹp nhất lượt đấu Champions League\" cho pha ấn định tỷ số 2-0 trước Man City.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Sáng 30/9, UEFA chọn ra bốn đề cử bàn thắng đẹp gồm bàn đầu tay của&nbsp;<a href=\"https://vnexpress.net/chu-de/lionel-messi-300\">Messi</a>&nbsp;(PSG), cú vuốt bóng của Alex Telles (Man Utd) vào lưới Villarreal, pha vẩy má ngoài của Sebastian Thill (Sheriff) trước&nbsp;<a href=\"https://vnexpress.net/the-thao/du-lieu-bong-da/doi-bong/real-madrid-541\">Real Madrid</a>&nbsp;và quả vô-lê của Antoine Griezmann (Atletico Madrid) tung lưới Milan.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/30/messi-jpeg-7737-1633016248.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=Kd66JZaYYIO9wjcg0ujbfA\" alt=\"Bàn đầu tiên của Messi cho PSG được chọn là tuyệt phẩm lượt đấu thứ hai của vòng bảng Champions League. Ảnh: Reuters\"/><figcaption>Bàn đầu tiên của Messi cho PSG được chọn là tuyệt phẩm lượt đấu thứ hai của vòng bảng Champions League. Ảnh:&nbsp;<em>Reuters</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Sau 12 tiếng nhận bình chọn từ độc giả trên trang chủ, UEFA công bố tuyệt phẩm của Messi nhận được nhiều phiếu bầu nhất. Thill đứng thứ hai với bàn thắng quyết định giúp Sheriff thắng Real 2-1 ngay tại Bernabeu ở phút 90. Telles về ba với cú vuốt bóng gỡ hoà 1-1 cho Man Utd. Còn Griezmann đứng cuối cũng với bàn gỡ hoà cho Atletico Madrid.</p>\n<!-- /wp:paragraph -->', 'Messi ghi bàn đẹp nhất lượt hai Champions League', '', 'inherit', 'closed', 'closed', '', '8-revision-v1', '', '', '2021-09-30 23:19:50', '2021-09-30 23:19:50', '', 8, 'http://wordpress.local/?p=9', 0, 'revision', '', 0),
(10, 1, '2021-09-30 23:20:13', '2021-09-30 23:20:13', '<!-- wp:paragraph -->\n<p>Jose Mourinho giúp AS Roma thắng đậm Zorya Luhansk 3-0 ở vòng bảng Europa Conference League, tối 30/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>*<em>Bàn thắng: El Shaarawy 7\', Smalling 66\', Abraham 68\'.</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đây là trận thứ 200 của nhà cầm quân người Bồ Đào Nha tại Cup châu Âu, cũng là chiến thắng thứ tám trong 10 trận ông dẫn dắt AS Roma. Đội bóng Italy đứng đầu bảng C sau hai trận toàn thắng. Ba điểm cũng giúp thầy trò Mourinho phần nào quên đi nỗi buồn thua Lazio 2-3 ở trận derby Rome cuối tuần trước.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/Untitled-6661-1633040982.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=60Hs2GokiACYi7SX3cv-ww\" alt=\"Abraham ghi bàn thứ hai cho Roma tại Europa Conference League. Ảnh: Reuters.\"/><figcaption>Abraham ghi bàn thứ hai cho Roma tại Europa Conference League. Ảnh:&nbsp;<em>Reuters</em>.</figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Làm khách của đội đứng thứ ba giải vô địch Ukraine mùa trước, Roma sớm thể hiện sự vượt trội. Stephan El Shaarawy phá bẫy việt vị để đón đường chọc khe của Ebrima Darboe. Anh lừa qua thủ thành Dmytro Matsapura rồi đưa bóng vào khung thành trống.</p>\n<!-- /wp:paragraph -->', 'Mourinho chạm mốc 200 trận tại Cup châu Âu', '', 'publish', 'open', 'open', '', 'mourinho-cham-moc-200-tran-tai-cup-chau-au', '', '', '2021-09-30 23:20:13', '2021-09-30 23:20:13', '', 0, 'http://wordpress.local/?p=10', 0, 'post', '', 0),
(11, 1, '2021-09-30 23:20:13', '2021-09-30 23:20:13', '<!-- wp:paragraph -->\n<p>Jose Mourinho giúp AS Roma thắng đậm Zorya Luhansk 3-0 ở vòng bảng Europa Conference League, tối 30/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>*<em>Bàn thắng: El Shaarawy 7\', Smalling 66\', Abraham 68\'.</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đây là trận thứ 200 của nhà cầm quân người Bồ Đào Nha tại Cup châu Âu, cũng là chiến thắng thứ tám trong 10 trận ông dẫn dắt AS Roma. Đội bóng Italy đứng đầu bảng C sau hai trận toàn thắng. Ba điểm cũng giúp thầy trò Mourinho phần nào quên đi nỗi buồn thua Lazio 2-3 ở trận derby Rome cuối tuần trước.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/Untitled-6661-1633040982.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=60Hs2GokiACYi7SX3cv-ww\" alt=\"Abraham ghi bàn thứ hai cho Roma tại Europa Conference League. Ảnh: Reuters.\"/><figcaption>Abraham ghi bàn thứ hai cho Roma tại Europa Conference League. Ảnh:&nbsp;<em>Reuters</em>.</figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Làm khách của đội đứng thứ ba giải vô địch Ukraine mùa trước, Roma sớm thể hiện sự vượt trội. Stephan El Shaarawy phá bẫy việt vị để đón đường chọc khe của Ebrima Darboe. Anh lừa qua thủ thành Dmytro Matsapura rồi đưa bóng vào khung thành trống.</p>\n<!-- /wp:paragraph -->', 'Mourinho chạm mốc 200 trận tại Cup châu Âu', '', 'inherit', 'closed', 'closed', '', '10-revision-v1', '', '', '2021-09-30 23:20:13', '2021-09-30 23:20:13', '', 10, 'http://wordpress.local/?p=11', 0, 'revision', '', 0),
(12, 1, '2021-09-30 23:20:37', '2021-09-30 23:20:37', '<!-- wp:paragraph -->\n<p>Thắng Kazakhstan 4-3 ở loạt luân lưu hôm 30/9, Bồ Đào Nha lần đầu tiên vào chung kết futsal World Cup.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Bồ Đào Nha được đánh giá cao hơn, nhưng nhập cuộc thiếu khí thế, không có nhiều cơ hội đủ sắc bén để đánh bại thủ môn Higuita. Một phần lý do là nhạc trưởng Ricardinho thi đấu kém ngẫu hứng hơn mọi khi.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đương kim vô địch châu Âu thậm chí để Kazakhstan làm tung lưới phút thứ 4, từ cú sút của Birzhan Orazov. Nhờ khiếu nại thành công, khi trọng tài kiểm tra VAR rồi xác định bóng đã đi hết đường biên, Bồ Đào Nha mới thoát bàn thua. Sau đó, họ còn phải nhờ đến cột dọc và xà ngang.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/gettyimages-1344118969-2048x20-7575-9489-1633032281.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=swNvtWRcSFw6ZD31lWJzAQ\" alt=\"Thủ môn Higuita (2) chơi xuất sắc nhưng không thể giúp Kazakhstan vào có lần đầu vào chung kết futsal World Cup. Ảnh: FIFA\"/><figcaption>Thủ môn Higuita (2) chơi xuất sắc nhưng không thể giúp Kazakhstan lần đầu vào chung kết futsal World Cup. Ảnh:&nbsp;<em>FIFA</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Hiệp hai sôi động hơn khi Bồ Đào Nha vượt lên. Phút 23, các cầu thủ Kazakhstan bị hút theo bóng, bỏ quên Pany. Trong tư thế trống trải, cầu thủ chạy cánh của Bồ Đào Nha sút vào góc gần trong thế đối diện thủ môn Higuita. Lần này, đến lượt Kazakhstan khiếu nại nhưng VAR vẫn công nhận bàn thắng vì xác định không có lỗi của cầu thủ Bồ Đào Nha.</p>\n<!-- /wp:paragraph -->', 'Bồ Đào Nha vào chung kết futsal World Cup', '', 'publish', 'open', 'open', '', 'bo-dao-nha-vao-chung-ket-futsal-world-cup', '', '', '2021-09-30 23:20:37', '2021-09-30 23:20:37', '', 0, 'http://wordpress.local/?p=12', 0, 'post', '', 0),
(13, 1, '2021-09-30 23:20:37', '2021-09-30 23:20:37', '<!-- wp:paragraph -->\n<p>Thắng Kazakhstan 4-3 ở loạt luân lưu hôm 30/9, Bồ Đào Nha lần đầu tiên vào chung kết futsal World Cup.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Bồ Đào Nha được đánh giá cao hơn, nhưng nhập cuộc thiếu khí thế, không có nhiều cơ hội đủ sắc bén để đánh bại thủ môn Higuita. Một phần lý do là nhạc trưởng Ricardinho thi đấu kém ngẫu hứng hơn mọi khi.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đương kim vô địch châu Âu thậm chí để Kazakhstan làm tung lưới phút thứ 4, từ cú sút của Birzhan Orazov. Nhờ khiếu nại thành công, khi trọng tài kiểm tra VAR rồi xác định bóng đã đi hết đường biên, Bồ Đào Nha mới thoát bàn thua. Sau đó, họ còn phải nhờ đến cột dọc và xà ngang.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/10/01/gettyimages-1344118969-2048x20-7575-9489-1633032281.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=swNvtWRcSFw6ZD31lWJzAQ\" alt=\"Thủ môn Higuita (2) chơi xuất sắc nhưng không thể giúp Kazakhstan vào có lần đầu vào chung kết futsal World Cup. Ảnh: FIFA\"/><figcaption>Thủ môn Higuita (2) chơi xuất sắc nhưng không thể giúp Kazakhstan lần đầu vào chung kết futsal World Cup. Ảnh:&nbsp;<em>FIFA</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Hiệp hai sôi động hơn khi Bồ Đào Nha vượt lên. Phút 23, các cầu thủ Kazakhstan bị hút theo bóng, bỏ quên Pany. Trong tư thế trống trải, cầu thủ chạy cánh của Bồ Đào Nha sút vào góc gần trong thế đối diện thủ môn Higuita. Lần này, đến lượt Kazakhstan khiếu nại nhưng VAR vẫn công nhận bàn thắng vì xác định không có lỗi của cầu thủ Bồ Đào Nha.</p>\n<!-- /wp:paragraph -->', 'Bồ Đào Nha vào chung kết futsal World Cup', '', 'inherit', 'closed', 'closed', '', '12-revision-v1', '', '', '2021-09-30 23:20:37', '2021-09-30 23:20:37', '', 12, 'http://wordpress.local/?p=13', 0, 'revision', '', 0),
(14, 1, '2021-09-30 23:21:08', '2021-09-30 23:21:08', '<!-- wp:paragraph -->\n<p>Oleksandr Usyk đánh cầm chừng với Anthony Joshua, vì không muốn làm tổn thương đối thủ trước khán giả nhà và gia đình tại London hôm 25/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"Sao mọi người cứ khát máu thế? Tôi đã thắng rồi. Mọi thứ vẫn ổn. Tại sao phải cố đánh gục đối phương? Joshua có người thân, bạn bè, bố mẹ, và khán giả theo dõi. Một võ sĩ sẽ bị ảnh hưởng đến sức khỏe nếu gục xuống sàn. Tôi không muốn điều đó xảy ra\", Usyk trả lời một câu hỏi của truyền thông Ukraine hôm 29/9.</p>\n<!-- /wp:paragraph -->', 'Usyk không muốn knock-out Joshua', '', 'publish', 'open', 'open', '', 'usyk-khong-muon-knock-out-joshua', '', '', '2021-09-30 23:21:08', '2021-09-30 23:21:08', '', 0, 'http://wordpress.local/?p=14', 0, 'post', '', 0),
(15, 1, '2021-09-30 23:21:08', '2021-09-30 23:21:08', '<!-- wp:paragraph -->\n<p>Oleksandr Usyk đánh cầm chừng với Anthony Joshua, vì không muốn làm tổn thương đối thủ trước khán giả nhà và gia đình tại London hôm 25/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"Sao mọi người cứ khát máu thế? Tôi đã thắng rồi. Mọi thứ vẫn ổn. Tại sao phải cố đánh gục đối phương? Joshua có người thân, bạn bè, bố mẹ, và khán giả theo dõi. Một võ sĩ sẽ bị ảnh hưởng đến sức khỏe nếu gục xuống sàn. Tôi không muốn điều đó xảy ra\", Usyk trả lời một câu hỏi của truyền thông Ukraine hôm 29/9.</p>\n<!-- /wp:paragraph -->', 'Usyk không muốn knock-out Joshua', '', 'inherit', 'closed', 'closed', '', '14-revision-v1', '', '', '2021-09-30 23:21:08', '2021-09-30 23:21:08', '', 14, 'http://wordpress.local/?p=15', 0, 'revision', '', 0),
(16, 1, '2021-09-30 23:22:03', '2021-09-30 23:22:03', '<!-- wp:paragraph -->\n<p>Viện Khoa học và Công nghệ Việt Nam - Hàn Quốc đi vào hoạt động bước đầu đã có doanh thu nhưng vẫn khó trong việc tìm nhà khoa học đầu ngành đứng nhóm.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tại kỳ họp hội đồng lần thứ 5 của Viện Khoa học và Công nghệ Việt Nam - Hàn Quốc (VKIST) sáng 30/9, các thành viên hội đồng cho biết cần gỡ khó khăn để thu hút nhân lực giỏi vào vị trí lãnh đạo, trưởng các nhóm nghiên cứu của Viện.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tại sự kiện, Bộ trưởng Khoa học và Công nghệ Huỳnh Thành Đạt, Chủ tịch hội đồng VKIST đánh giá cao kết quả sau 4 năm Viện đi vào hoạt động. Vấn đề hiện tại cần giải quyết là hoàn thiện bộ máy để VKIST bắt tay vào nghiên cứu phát triển. Bên cạnh đó Bộ trưởng cũng lưu ý Viện xây dựng khung chương trình khoa học công nghệ tạo sự gắn kết, thống nhất triển khai các nhiệm vụ khoa học công nghệ với Bộ Khoa học và Công nghệ.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Theo Bộ trưởng, ở giai đoạn tới, VKIST cần nâng cao năng lực nghiên cứu ứng dụng trong các lĩnh vực ưu tiên, kết hợp hệ thống dịch vụ khoa học và công nghệ, hướng đến là đơn vị tự chủ tài chính.</p>\n<!-- /wp:paragraph -->', 'Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST', '', 'publish', 'open', 'open', '', 'tim-nguoi-gioi-cho-nhung-nghien-cuu-hang-dau-tai-vkist', '', '', '2021-09-30 23:22:03', '2021-09-30 23:22:03', '', 0, 'http://wordpress.local/?p=16', 0, 'post', '', 0),
(17, 1, '2021-09-30 23:22:03', '2021-09-30 23:22:03', '<!-- wp:paragraph -->\n<p>Viện Khoa học và Công nghệ Việt Nam - Hàn Quốc đi vào hoạt động bước đầu đã có doanh thu nhưng vẫn khó trong việc tìm nhà khoa học đầu ngành đứng nhóm.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tại kỳ họp hội đồng lần thứ 5 của Viện Khoa học và Công nghệ Việt Nam - Hàn Quốc (VKIST) sáng 30/9, các thành viên hội đồng cho biết cần gỡ khó khăn để thu hút nhân lực giỏi vào vị trí lãnh đạo, trưởng các nhóm nghiên cứu của Viện.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tại sự kiện, Bộ trưởng Khoa học và Công nghệ Huỳnh Thành Đạt, Chủ tịch hội đồng VKIST đánh giá cao kết quả sau 4 năm Viện đi vào hoạt động. Vấn đề hiện tại cần giải quyết là hoàn thiện bộ máy để VKIST bắt tay vào nghiên cứu phát triển. Bên cạnh đó Bộ trưởng cũng lưu ý Viện xây dựng khung chương trình khoa học công nghệ tạo sự gắn kết, thống nhất triển khai các nhiệm vụ khoa học công nghệ với Bộ Khoa học và Công nghệ.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Theo Bộ trưởng, ở giai đoạn tới, VKIST cần nâng cao năng lực nghiên cứu ứng dụng trong các lĩnh vực ưu tiên, kết hợp hệ thống dịch vụ khoa học và công nghệ, hướng đến là đơn vị tự chủ tài chính.</p>\n<!-- /wp:paragraph -->', 'Tìm người giỏi cho những nghiên cứu hàng đầu tại VKIST', '', 'inherit', 'closed', 'closed', '', '16-revision-v1', '', '', '2021-09-30 23:22:03', '2021-09-30 23:22:03', '', 16, 'http://wordpress.local/?p=17', 0, 'revision', '', 0),
(18, 1, '2021-09-30 23:22:29', '2021-09-30 23:22:29', '<!-- wp:paragraph -->\n<p>Các chuyên gia phát triển mẫu pin gồm nhiều viên nhỏ và cứng, liên kết với nhau, có thể dễ dàng thay đổi hình dạng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-vnexpress.vnecdn.net/2021/09/30/Pin-ran-7204-1632994229.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=aCnMLzcgDlUoLSE-bQPjag\" alt=\"Loại pin dẻo do Viện Máy móc và Vật liệu Hàn Quốc phát triển quấn quanh cánh tay. Ảnh: KIMM\"/><figcaption>Pin vảy rắn của Viện Máy móc và Vật liệu Hàn Quốc quấn quanh một cánh tay. Ảnh:&nbsp;<em>KIMM</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Nhóm kỹ sư tại Viện Máy móc và Vật liệu Hàn Quốc (KIMM) phát triển mẫu pin với khả năng uốn cong và giãn ra như rắn, có tiềm năng ứng dụng cho thiết bị điện tử đeo trên người và các robot mềm dùng trong quản lý thảm họa,&nbsp;<em>Independent</em>&nbsp;hôm 28/9 đưa tin. Thiết bị mới được miêu tả chi tiết trên tạp chí Soft Robotics.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Họ cho biết, cấu trúc pin lấy cảm hứng từ vảy rắn. Vảy rắn cứng nhưng có thể xếp lại với nhau để bảo vệ con vật khỏi tác động từ bên ngoài, đồng thời sở hữu những đặc điểm cho phép chúng có độ co giãn cao và khả năng di chuyển linh hoạt.</p>\n<!-- /wp:paragraph -->', 'Pin có thể uốn và co giãn như rắn', '', 'publish', 'open', 'open', '', 'pin-co-the-uon-va-co-gian-nhu-ran', '', '', '2021-09-30 23:22:29', '2021-09-30 23:22:29', '', 0, 'http://wordpress.local/?p=18', 0, 'post', '', 0),
(19, 1, '2021-09-30 23:22:29', '2021-09-30 23:22:29', '<!-- wp:paragraph -->\n<p>Các chuyên gia phát triển mẫu pin gồm nhiều viên nhỏ và cứng, liên kết với nhau, có thể dễ dàng thay đổi hình dạng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-vnexpress.vnecdn.net/2021/09/30/Pin-ran-7204-1632994229.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=aCnMLzcgDlUoLSE-bQPjag\" alt=\"Loại pin dẻo do Viện Máy móc và Vật liệu Hàn Quốc phát triển quấn quanh cánh tay. Ảnh: KIMM\"/><figcaption>Pin vảy rắn của Viện Máy móc và Vật liệu Hàn Quốc quấn quanh một cánh tay. Ảnh:&nbsp;<em>KIMM</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Nhóm kỹ sư tại Viện Máy móc và Vật liệu Hàn Quốc (KIMM) phát triển mẫu pin với khả năng uốn cong và giãn ra như rắn, có tiềm năng ứng dụng cho thiết bị điện tử đeo trên người và các robot mềm dùng trong quản lý thảm họa,&nbsp;<em>Independent</em>&nbsp;hôm 28/9 đưa tin. Thiết bị mới được miêu tả chi tiết trên tạp chí Soft Robotics.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Họ cho biết, cấu trúc pin lấy cảm hứng từ vảy rắn. Vảy rắn cứng nhưng có thể xếp lại với nhau để bảo vệ con vật khỏi tác động từ bên ngoài, đồng thời sở hữu những đặc điểm cho phép chúng có độ co giãn cao và khả năng di chuyển linh hoạt.</p>\n<!-- /wp:paragraph -->', 'Pin có thể uốn và co giãn như rắn', '', 'inherit', 'closed', 'closed', '', '18-revision-v1', '', '', '2021-09-30 23:22:29', '2021-09-30 23:22:29', '', 18, 'http://wordpress.local/?p=19', 0, 'revision', '', 0),
(23, 1, '2021-10-25 09:31:16', '2021-10-25 09:31:16', ' ', '', '', 'publish', 'closed', 'closed', '', '23', '', '', '2021-10-25 09:31:16', '2021-10-25 09:31:16', '', 0, 'http://wordpress.local:90/?p=23', 1, 'nav_menu_item', '', 0),
(24, 1, '2021-10-25 09:31:16', '2021-10-25 09:31:16', ' ', '', '', 'publish', 'closed', 'closed', '', '24', '', '', '2021-10-25 09:31:16', '2021-10-25 09:31:16', '', 0, 'http://wordpress.local:90/?p=24', 2, 'nav_menu_item', '', 0),
(25, 1, '2021-11-09 15:15:53', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2021-11-09 15:15:53', '0000-00-00 00:00:00', '', 0, 'http://wordpress.local:90/?p=25', 0, 'post', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp581_termmeta`
--

CREATE TABLE `wp581_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp581_terms`
--

CREATE TABLE `wp581_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_terms`
--

INSERT INTO `wp581_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(2, 'Thể thao', 'the-thao', 0),
(3, 'Giải trí', 'giai-tri', 0),
(4, 'Khoa học', 'khoa-hoc', 0),
(5, 'Giáo dục', 'giao-duc', 0),
(7, 'CategoryMenu', 'categorymenu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp581_term_relationships`
--

CREATE TABLE `wp581_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_term_relationships`
--

INSERT INTO `wp581_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(4, 2, 0),
(6, 2, 0),
(8, 2, 0),
(10, 2, 0),
(12, 2, 0),
(14, 2, 0),
(16, 4, 0),
(18, 4, 0),
(23, 7, 0),
(24, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp581_term_taxonomy`
--

CREATE TABLE `wp581_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_term_taxonomy`
--

INSERT INTO `wp581_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1),
(2, 2, 'category', '', 0, 6),
(3, 3, 'category', '', 0, 0),
(4, 4, 'category', '', 0, 2),
(5, 5, 'category', '', 0, 0),
(7, 7, 'nav_menu', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `wp581_usermeta`
--

CREATE TABLE `wp581_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_usermeta`
--

INSERT INTO `wp581_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'admin'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp581_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp581_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:\"ba3828c184dddf9ad650e7ae5e1696731724aaac5b31985e8970e4455caa2a07\";a:4:{s:10:\"expiration\";i:1636643751;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:110:\"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.100 Safari/537.36\";s:5:\"login\";i:1636470951;}}'),
(17, 1, 'wp581_user-settings', 'libraryContent=browse'),
(18, 1, 'wp581_user-settings-time', '1633043815'),
(19, 1, 'wp581_dashboard_quick_press_last_post_id', '25'),
(20, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(21, 1, 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:\"add-post_tag\";}'),
(22, 1, 'nav_menu_recently_edited', '7');

-- --------------------------------------------------------

--
-- Table structure for table `wp581_users`
--

CREATE TABLE `wp581_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp581_users`
--

INSERT INTO `wp581_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BNwRT2aq1Ac4QT6RZ4hs3GYmA2FzYV1', 'admin', 'tailieuweb.com@gmail.com', 'http://wordpress.local', '2021-09-30 22:59:54', '', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'A WordPress Commenter', 'wapuu@wordpress.example', 'https://wordpress.org/', '', '2021-09-16 03:48:34', '2021-09-16 03:48:34', 'Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href=\"https://gravatar.com\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://wordpress.local:90/', 'yes'),
(2, 'home', 'http://wordpress.local:90/', 'yes'),
(3, 'blogname', 'WordPress 581', 'yes'),
(4, 'blogdescription', 'Just another WordPress site', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'admin@admin.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:96:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:0:{}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', 'a:2:{i:0;s:104:\"D:\\2-tdc\\2021-2022-HK1\\1-cms\\2-source-wordpress-581\\wordpress/wp-content/themes/twentynineteen/style.css\";i:1;s:0:\"\";}', 'no'),
(40, 'template', 'twentytwenty', 'yes'),
(41, 'stylesheet', 'twentytwenty', 'yes'),
(42, 'comment_registration', '0', 'yes'),
(43, 'html_type', 'text/html', 'yes'),
(44, 'use_trackback', '0', 'yes'),
(45, 'default_role', 'subscriber', 'yes'),
(46, 'db_version', '49752', 'yes'),
(47, 'uploads_use_yearmonth_folders', '1', 'yes'),
(48, 'upload_path', '', 'yes'),
(49, 'blog_public', '1', 'yes'),
(50, 'default_link_category', '2', 'yes'),
(51, 'show_on_front', 'posts', 'yes'),
(52, 'tag_base', '', 'yes'),
(53, 'show_avatars', '1', 'yes'),
(54, 'avatar_rating', 'G', 'yes'),
(55, 'upload_url_path', '', 'yes'),
(56, 'thumbnail_size_w', '150', 'yes'),
(57, 'thumbnail_size_h', '150', 'yes'),
(58, 'thumbnail_crop', '1', 'yes'),
(59, 'medium_size_w', '300', 'yes'),
(60, 'medium_size_h', '300', 'yes'),
(61, 'avatar_default', 'mystery', 'yes'),
(62, 'large_size_w', '1024', 'yes'),
(63, 'large_size_h', '1024', 'yes'),
(64, 'image_default_link_type', 'none', 'yes'),
(65, 'image_default_size', '', 'yes'),
(66, 'image_default_align', '', 'yes'),
(67, 'close_comments_for_old_posts', '0', 'yes'),
(68, 'close_comments_days_old', '14', 'yes'),
(69, 'thread_comments', '1', 'yes'),
(70, 'thread_comments_depth', '5', 'yes'),
(71, 'page_comments', '0', 'yes'),
(72, 'comments_per_page', '50', 'yes'),
(73, 'default_comments_page', 'newest', 'yes'),
(74, 'comment_order', 'asc', 'yes'),
(75, 'sticky_posts', 'a:0:{}', 'yes'),
(76, 'widget_categories', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(77, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(78, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(79, 'uninstall_plugins', 'a:0:{}', 'no'),
(80, 'timezone_string', '', 'yes'),
(81, 'page_for_posts', '0', 'yes'),
(82, 'page_on_front', '0', 'yes'),
(83, 'default_post_format', '0', 'yes'),
(84, 'link_manager_enabled', '0', 'yes'),
(85, 'finished_splitting_shared_terms', '1', 'yes'),
(86, 'site_icon', '0', 'yes'),
(87, 'medium_large_size_w', '768', 'yes'),
(88, 'medium_large_size_h', '0', 'yes'),
(89, 'wp_page_for_privacy_policy', '3', 'yes'),
(90, 'show_comments_cookies_opt_in', '1', 'yes'),
(91, 'admin_email_lifespan', '1647316113', 'yes'),
(92, 'disallowed_keys', '', 'no'),
(93, 'comment_previously_approved', '1', 'yes'),
(94, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
(95, 'auto_update_core_dev', 'enabled', 'yes'),
(96, 'auto_update_core_minor', 'enabled', 'yes'),
(97, 'auto_update_core_major', 'enabled', 'yes'),
(98, 'wp_force_deactivated_plugins', 'a:0:{}', 'yes'),
(99, 'initial_db_version', '49752', 'yes'),
(100, 'wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(101, 'fresh_site', '0', 'yes'),
(102, 'widget_block', 'a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:154:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Posts</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:227:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Comments</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'sidebars_widgets', 'a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:9:\"sidebar-2\";a:0:{}s:13:\"array_version\";i:3;}', 'yes'),
(104, 'cron', 'a:7:{i:1636548515;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1636559315;a:4:{s:18:\"wp_https_detection\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1636602515;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1636602530;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1636602533;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1636688915;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(105, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(113, 'widget_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(114, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(115, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(116, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(118, 'recovery_keys', 'a:0:{}', 'yes'),
(119, 'theme_mods_twentytwentyone', 'a:3:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1632349007;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}}}s:18:\"nav_menu_locations\";a:2:{s:6:\"footer\";i:9;s:7:\"primary\";i:9;}}', 'yes'),
(121, 'https_detection_errors', 'a:1:{s:20:\"https_request_failed\";a:1:{i:0;s:21:\"HTTPS request failed.\";}}', 'yes'),
(122, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.8.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.8.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.8.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.8.1-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"5.8.1\";s:7:\"version\";s:5:\"5.8.1\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.6\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1636541228;s:15:\"version_checked\";s:5:\"5.8.1\";s:12:\"translations\";a:0:{}}', 'no'),
(127, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1636541231;s:7:\"checked\";a:3:{s:14:\"twentynineteen\";s:3:\"2.1\";s:12:\"twentytwenty\";s:3:\"1.8\";s:15:\"twentytwentyone\";s:3:\"1.4\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:3:{s:14:\"twentynineteen\";a:6:{s:5:\"theme\";s:14:\"twentynineteen\";s:11:\"new_version\";s:3:\"2.1\";s:3:\"url\";s:44:\"https://wordpress.org/themes/twentynineteen/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/twentynineteen.2.1.zip\";s:8:\"requires\";s:5:\"4.9.6\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:12:\"twentytwenty\";a:6:{s:5:\"theme\";s:12:\"twentytwenty\";s:11:\"new_version\";s:3:\"1.8\";s:3:\"url\";s:42:\"https://wordpress.org/themes/twentytwenty/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/theme/twentytwenty.1.8.zip\";s:8:\"requires\";s:3:\"4.7\";s:12:\"requires_php\";s:5:\"5.2.4\";}s:15:\"twentytwentyone\";a:6:{s:5:\"theme\";s:15:\"twentytwentyone\";s:11:\"new_version\";s:3:\"1.4\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentyone/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentyone.1.4.zip\";s:8:\"requires\";s:3:\"5.3\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}', 'no'),
(133, 'can_compress_scripts', '1', 'no'),
(148, 'finished_updating_comment_type', '1', 'yes'),
(166, '_transient_health-check-site-status-result', '{\"good\":13,\"recommended\":5,\"critical\":1}', 'yes'),
(183, 'widget_recent-comments', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(184, 'widget_recent-posts', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(202, 'category_children', 'a:1:{i:2;a:3:{i:0;i:6;i:1;i:7;i:2;i:8;}}', 'yes'),
(213, 'current_theme', 'Twenty Twenty', 'yes'),
(214, 'theme_mods_twentynineteen', 'a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:3:{s:6:\"menu-1\";i:9;s:6:\"footer\";i:9;s:6:\"social\";i:9;}s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1632365498;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}}}}', 'yes'),
(215, 'theme_switched', '', 'yes'),
(216, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:\"auto_add\";a:0:{}}', 'yes'),
(235, 'theme_mods_twentytwenty', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:3:{s:6:\"footer\";i:9;s:6:\"social\";i:9;s:7:\"primary\";i:9;}s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(305, '_site_transient_timeout_theme_roots', '1636543021', 'no'),
(306, '_site_transient_theme_roots', 'a:3:{s:14:\"twentynineteen\";s:7:\"/themes\";s:12:\"twentytwenty\";s:7:\"/themes\";s:15:\"twentytwentyone\";s:7:\"/themes\";}', 'no'),
(307, '_site_transient_timeout_php_check_26328e95a1a09d326a615e4b43668741', '1637146022', 'no'),
(308, '_site_transient_php_check_26328e95a1a09d326a615e4b43668741', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"5.6.20\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'no'),
(310, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1636541232;s:8:\"response\";a:1:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.2.1\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.2.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";s:6:\"tested\";s:5:\"5.8.1\";s:12:\"requires_php\";b:0;}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:1:{s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}}s:7:\"checked\";a:2:{s:19:\"akismet/akismet.php\";s:6:\"4.1.12\";s:9:\"hello.php\";s:5:\"1.7.2\";}}', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(11, 10, '_edit_lock', '1632348730:1'),
(14, 12, '_edit_lock', '1632348744:1'),
(18, 15, '_wp_attached_file', '2021/09/messi-0650-1.jpg'),
(19, 15, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2048;s:6:\"height\";i:1152;s:4:\"file\";s:24:\"2021/09/messi-0650-1.jpg\";s:5:\"sizes\";a:6:{s:6:\"medium\";a:4:{s:4:\"file\";s:24:\"messi-0650-1-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:25:\"messi-0650-1-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"messi-0650-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:24:\"messi-0650-1-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:25:\"messi-0650-1-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:25:\"messi-0650-1-1568x882.jpg\";s:5:\"width\";i:1568;s:6:\"height\";i:882;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(20, 16, '_wp_attached_file', '2021/09/messi-0650.jpg'),
(21, 16, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2048;s:6:\"height\";i:1152;s:4:\"file\";s:22:\"2021/09/messi-0650.jpg\";s:5:\"sizes\";a:6:{s:6:\"medium\";a:4:{s:4:\"file\";s:22:\"messi-0650-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:23:\"messi-0650-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:22:\"messi-0650-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:22:\"messi-0650-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:23:\"messi-0650-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:23:\"messi-0650-1568x882.jpg\";s:5:\"width\";i:1568;s:6:\"height\";i:882;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(22, 17, '_wp_attached_file', '2021/09/messi-chan-thuong-1.jpg'),
(23, 17, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:840;s:6:\"height\";i:472;s:4:\"file\";s:31:\"2021/09/messi-chan-thuong-1.jpg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:31:\"messi-chan-thuong-1-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:31:\"messi-chan-thuong-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:31:\"messi-chan-thuong-1-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(24, 18, '_wp_attached_file', '2021/09/psg.jpeg'),
(25, 18, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1200;s:6:\"height\";i:745;s:4:\"file\";s:16:\"2021/09/psg.jpeg\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:16:\"psg-300x186.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:186;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:17:\"psg-1024x636.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:636;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:16:\"psg-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:16:\"psg-768x477.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:477;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(26, 19, '_wp_attached_file', '2021/09/psg-gap-hoa-lon-voi-lionel-messi.jpg'),
(27, 19, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:800;s:6:\"height\";i:551;s:4:\"file\";s:44:\"2021/09/psg-gap-hoa-lon-voi-lionel-messi.jpg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:44:\"psg-gap-hoa-lon-voi-lionel-messi-300x207.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:207;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:44:\"psg-gap-hoa-lon-voi-lionel-messi-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:44:\"psg-gap-hoa-lon-voi-lionel-messi-768x529.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:529;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(28, 20, '_wp_attached_file', '2021/09/download.jpg'),
(29, 20, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:299;s:6:\"height\";i:168;s:4:\"file\";s:20:\"2021/09/download.jpg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:20:\"download-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(30, 21, '_wp_attached_file', '2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap.jpg'),
(31, 21, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:635;s:6:\"height\";i:394;s:4:\"file\";s:53:\"2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap.jpg\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:53:\"koeman-messi-la-mot-bao-chua-tren-san-tap-300x186.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:186;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:53:\"koeman-messi-la-mot-bao-chua-tren-san-tap-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(32, 22, '_wp_attached_file', '2021/09/Lionel_Messi_20180626.jpg'),
(33, 22, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:701;s:6:\"height\";i:1000;s:4:\"file\";s:33:\"2021/09/Lionel_Messi_20180626.jpg\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:33:\"Lionel_Messi_20180626-210x300.jpg\";s:5:\"width\";i:210;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:33:\"Lionel_Messi_20180626-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}'),
(34, 23, '_wp_attached_file', '2021/09/messi_cies.jpeg'),
(35, 23, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:960;s:6:\"height\";i:631;s:4:\"file\";s:23:\"2021/09/messi_cies.jpeg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:23:\"messi_cies-300x197.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:197;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"messi_cies-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:23:\"messi_cies-768x505.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:505;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(36, 24, '_wp_attached_file', '2021/09/messi_lyld.jpeg'),
(37, 24, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:976;s:6:\"height\";i:549;s:4:\"file\";s:23:\"2021/09/messi_lyld.jpeg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:23:\"messi_lyld-300x169.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"messi_lyld-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:23:\"messi_lyld-768x432.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(38, 25, '_wp_attached_file', '2021/09/messi-0650-2.jpg'),
(39, 25, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2048;s:6:\"height\";i:1152;s:4:\"file\";s:24:\"2021/09/messi-0650-2.jpg\";s:5:\"sizes\";a:6:{s:6:\"medium\";a:4:{s:4:\"file\";s:24:\"messi-0650-2-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:25:\"messi-0650-2-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"messi-0650-2-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:24:\"messi-0650-2-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:25:\"messi-0650-2-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:25:\"messi-0650-2-1568x882.jpg\";s:5:\"width\";i:1568;s:6:\"height\";i:882;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(40, 26, '_wp_attached_file', '2021/09/messi-chan-thuong-1-1.jpg'),
(41, 26, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:840;s:6:\"height\";i:472;s:4:\"file\";s:33:\"2021/09/messi-chan-thuong-1-1.jpg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:33:\"messi-chan-thuong-1-1-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:33:\"messi-chan-thuong-1-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:33:\"messi-chan-thuong-1-1-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(42, 27, '_wp_attached_file', '2021/09/psg-1.jpeg'),
(43, 27, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1200;s:6:\"height\";i:745;s:4:\"file\";s:18:\"2021/09/psg-1.jpeg\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"psg-1-300x186.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:186;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:19:\"psg-1-1024x636.jpeg\";s:5:\"width\";i:1024;s:6:\"height\";i:636;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"psg-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:18:\"psg-1-768x477.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:477;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(44, 28, '_wp_attached_file', '2021/09/psg-gap-hoa-lon-voi-lionel-messi-1.jpg'),
(45, 28, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:800;s:6:\"height\";i:551;s:4:\"file\";s:46:\"2021/09/psg-gap-hoa-lon-voi-lionel-messi-1.jpg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:46:\"psg-gap-hoa-lon-voi-lionel-messi-1-300x207.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:207;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:46:\"psg-gap-hoa-lon-voi-lionel-messi-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:46:\"psg-gap-hoa-lon-voi-lionel-messi-1-768x529.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:529;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(46, 29, '_wp_attached_file', '2021/09/download-1.jpg'),
(47, 29, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:299;s:6:\"height\";i:168;s:4:\"file\";s:22:\"2021/09/download-1.jpg\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:22:\"download-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(48, 30, '_wp_attached_file', '2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap-1.jpg'),
(49, 30, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:635;s:6:\"height\";i:394;s:4:\"file\";s:55:\"2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap-1.jpg\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:55:\"koeman-messi-la-mot-bao-chua-tren-san-tap-1-300x186.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:186;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:55:\"koeman-messi-la-mot-bao-chua-tren-san-tap-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(50, 31, '_wp_attached_file', '2021/09/Lionel_Messi_20180626-1.jpg'),
(51, 31, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:701;s:6:\"height\";i:1000;s:4:\"file\";s:35:\"2021/09/Lionel_Messi_20180626-1.jpg\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:35:\"Lionel_Messi_20180626-1-210x300.jpg\";s:5:\"width\";i:210;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:35:\"Lionel_Messi_20180626-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}'),
(52, 32, '_wp_attached_file', '2021/09/messi_cies-1.jpeg'),
(53, 32, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:960;s:6:\"height\";i:631;s:4:\"file\";s:25:\"2021/09/messi_cies-1.jpeg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:25:\"messi_cies-1-300x197.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:197;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"messi_cies-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:25:\"messi_cies-1-768x505.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:505;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(54, 33, '_wp_attached_file', '2021/09/messi_lyld-1.jpeg'),
(55, 33, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:976;s:6:\"height\";i:549;s:4:\"file\";s:25:\"2021/09/messi_lyld-1.jpeg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:25:\"messi_lyld-1-300x169.jpeg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:25:\"messi_lyld-1-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:25:\"messi_lyld-1-768x432.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(56, 34, '_wp_attached_file', '2021/09/messi-0650-1-1.jpg'),
(57, 34, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2048;s:6:\"height\";i:1152;s:4:\"file\";s:26:\"2021/09/messi-0650-1-1.jpg\";s:5:\"sizes\";a:6:{s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"messi-0650-1-1-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:27:\"messi-0650-1-1-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:26:\"messi-0650-1-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:26:\"messi-0650-1-1-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"1536x1536\";a:4:{s:4:\"file\";s:27:\"messi-0650-1-1-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:27:\"messi-0650-1-1-1568x882.jpg\";s:5:\"width\";i:1568;s:6:\"height\";i:882;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(58, 1, '_edit_lock', '1632348598:1'),
(63, 37, '_edit_lock', '1633041904:1'),
(70, 40, '_menu_item_type', 'post_type'),
(71, 40, '_menu_item_menu_item_parent', '0'),
(72, 40, '_menu_item_object_id', '12'),
(73, 40, '_menu_item_object', 'page'),
(74, 40, '_menu_item_target', ''),
(75, 40, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(76, 40, '_menu_item_xfn', ''),
(77, 40, '_menu_item_url', ''),
(79, 41, '_menu_item_type', 'post_type'),
(80, 41, '_menu_item_menu_item_parent', '0'),
(81, 41, '_menu_item_object_id', '2'),
(82, 41, '_menu_item_object', 'page'),
(83, 41, '_menu_item_target', ''),
(84, 41, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(85, 41, '_menu_item_xfn', ''),
(86, 41, '_menu_item_url', ''),
(88, 42, '_menu_item_type', 'custom'),
(89, 42, '_menu_item_menu_item_parent', '0'),
(90, 42, '_menu_item_object_id', '42'),
(91, 42, '_menu_item_object', 'custom'),
(92, 42, '_menu_item_target', ''),
(93, 42, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(94, 42, '_menu_item_xfn', ''),
(95, 42, '_menu_item_url', 'http://test'),
(96, 42, '_menu_item_orphaned', '1632348878'),
(97, 43, '_menu_item_type', 'custom'),
(98, 43, '_menu_item_menu_item_parent', '0'),
(99, 43, '_menu_item_object_id', '43'),
(100, 43, '_menu_item_object', 'custom'),
(101, 43, '_menu_item_target', ''),
(102, 43, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(103, 43, '_menu_item_xfn', ''),
(104, 43, '_menu_item_url', 'http://test2'),
(105, 43, '_menu_item_orphaned', '1632348886'),
(106, 44, '_menu_item_type', 'post_type'),
(107, 44, '_menu_item_menu_item_parent', '0'),
(108, 44, '_menu_item_object_id', '37'),
(109, 44, '_menu_item_object', 'post'),
(110, 44, '_menu_item_target', ''),
(111, 44, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(112, 44, '_menu_item_xfn', ''),
(113, 44, '_menu_item_url', ''),
(115, 45, '_menu_item_type', 'custom'),
(116, 45, '_menu_item_menu_item_parent', '0'),
(117, 45, '_menu_item_object_id', '45'),
(118, 45, '_menu_item_object', 'custom'),
(119, 45, '_menu_item_target', ''),
(120, 45, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(121, 45, '_menu_item_xfn', ''),
(122, 45, '_menu_item_url', 'http://test1');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2021-09-16 03:48:34', '2021-09-16 03:48:34', '<!-- wp:paragraph -->\n<p><em>Ghi bàn: Đắc Huy 18, Đức Hoà 39 - Robinho 11, Chishkala 18, 30</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Năm năm trước tại Colombia, Nga thắng Việt Nam tới 7-0 cũng ở vòng 1/8 futsal World Cup, nhưng lần này tình thế đã thay đổi. Ở Vilnius tối 22/9, Nga không có lúc nào tạo được cách biệt ba bàn trước Việt Nam. Thầy trò Phạm Minh Giang thậm chí ghi được hai bàn nhờ công của pivot Nguyễn Đắc Huy và hậu vệ Phạm Đức Hoà. Nhưng, Nga vẫn đi tiếp vào tứ kết nhờ bàn thắng của Robinho và cú đúp cho Ivan Chishkala.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/da-c-huy-jpeg-1632328254-5170-1632328316.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=6Ba7xTBALBjafsR5w4ziVw\" alt=\"Đắc Huy (phải) mừng bàn sau khi đánh đầu nối từ đường chuyền bằng đầu của Gia Hưng (trái). Ảnh: VFF\"/><figcaption>Đắc Huy (phải) mừng bàn sau khi đánh đầu nối từ đường chuyền bằng đầu của Gia Hưng (trái). Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Không bất ngờ khi Việt Nam chọn lối chơi phòng ngự phản công quen thuộc, khi đội chỉ giữ bóng 28% thời lượng hiệp một. Đoàn quân của Minh Giang đứng vững trong 10 phút đầu tiên, nhờ vào ít nhất năm pha cứu thua đẹp mắt của thủ môn Hồ Văn Ý. Anh liên tục bay người, chuồi xuống, vươn tay phá bóng hay thậm chí dùng thân mình để ngăn cú sút của đối phương.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đến phút 11, Nga bất ngờ thay đổi chiến thuật, bằng cách cắm ba cầu thủ vào cấm địa Việt Nam và để Robinho cầm bóng qua người. Tiền vệ 38 tuổi gốc Brazil vượt qua Văn Hoà bên phải, chuyền vào cho Afanasev làm tường. Lúc này thủ môn Văn Ý phải lao ra để làm hẹp góc sút, nhưng Afanasev lại gạt sang cho Robinho đệm vào khung thành trống để mở tỷ số.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/hoa-jpeg-1632328178-1632328196-9087-1632328316.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=qJ_yq9Bx9r38FLAdxsJ15g\" alt=\"Tình huống Robinho (trái) vượt qua Đức Hoà trước khi ghi bàn. Ảnh: VFF\"/><figcaption>Tình huống Robinho (trái) vượt qua Đức Hoà trước khi ghi bàn. Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Robinho sau khi ghi bàn, ra sân nghỉ vài phút. Sau khi trở lại, anh đá biên cho Chishkala sút một chạm đưa bóng đi qua hai chân thủ môn Văn Ý, rồi lăn vào lưới. Nga dẫn 2-0 khi hiệp một chỉ còn hai phút. Hai cầu thủ này được coi là cặp bài trùng của Nga, khi cùng chơi cho CLB Benfica ở Bồ Đào Nha.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nhưng thế dẫn hai bàn của Nga chỉ tồn tại vài giây, khi Việt Nam rút ngắn tỷ số chóng vánh. Thủ môn Văn Ý chuyền dài lên cho Gia Hưng đánh đầu vào cấm địa. Đắc Huy ập vào đánh đầu nối cận thành hạ gục thủ môn Putilov. Sau khi ghi bàn, Đắc Huy giơ áo số 10 của pivot Nguyễn Đức Tùng lên, để tri ân cầu thủ này bị chấn thương đầu gối nặng từ trận cuối vòng bảng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nga không chấp nhận thắng cách biệt một bàn, mà dồn lên tấn công đầu hiệp hai. Sau khi Artem Niyazov và Sergei Abramov sút trúng cột dọc liên tiếp, đoàn quân của HLV Sergey Skorovich cũng ghi được bàn thứ ba. Lại là Robinho chuyền bóng để Chishkala xử lý ngoài cấm địa. Chishkala rê bóng xuống biên trái, vượt qua Minh Trí, rồi sút chìm chéo góc hạ gục thủ môn Văn Ý. Đây là bàn thứ năm của anh tại giải, còn Robinho có tình huống thứ tám ghi dấu giày vào bàn thắng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nhưng, Việt Nam vẫn không nản chí để tìm bàn gỡ thêm. Sau khi tiền vệ trẻ Nguyễn Văn Hiếu đệm bóng chệch cột, Việt Nam chuyển sang chơi power-play. Từ một tình huống như thế ở phút 39, đội trưởng Trần Văn Vũ cướp bóng trong chân Ivan Milovanov ngay rìa cấm địa Nga. Đức Hoà đứng ngay cạnh, thúc mũi giày đưa bóng đi căng và tung lưới Nga, khi thủ môn Dmitri Putilov không kịp trở tay.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/duc-hoa-jpeg-7043-1632329313.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=CkKk4i9PRTWjWJiTJDAD5w\" alt=\"Việt Nam (áo đỏ) dừng bước ở vòng 1/8, lần thứ hai liên tiếp. Ảnh: VFF\"/><figcaption>Việt Nam (áo đỏ) dừng bước ở vòng 1/8, lần thứ hai liên tiếp. Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Với cách biệt chỉ còn một bàn, Việt Nam tất tay để tìm bàn gỡ hoà nhằm đưa trận đấu vào hiệp phụ. Nhưng, cơ hội cuối của Minh Trí không thể thành bàn, khi anh sút từ góc hẹp suýt qua được hai chân thủ môn Nga.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Trận thua sát nút 2-3 cũng là kết quả nằm ngoài dự đoán, cho thấy Việt Nam phần nào đã tiến bộ so với lần đầu dự futsal World Cup năm 2016. Tỷ số này cũng là bất ngờ khi Nga đang hơn Việt Nam 35 bậc thế giới. Nga sẽ vào tứ kết gặp đương kim vô địch Argentina hoặc Paraguay.</p>\n<!-- /wp:paragraph -->', 'Việt Nam thua sát Nga ở vòng 1/8 futsal World Cup', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2021-09-22 22:07:49', '2021-09-22 22:07:49', '', 0, 'http://localhost/wordpress_581/?p=1', 0, 'post', '', 1),
(2, 1, '2021-09-16 03:48:34', '2021-09-16 03:48:34', '<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://localhost/wordpress_581/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2021-09-16 03:48:34', '2021-09-16 03:48:34', '', 0, 'http://localhost/wordpress_581/?page_id=2', 0, 'page', '', 0),
(3, 1, '2021-09-16 03:48:34', '2021-09-16 03:48:34', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://localhost/wordpress_581.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Comments</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Media</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Embedded content from other websites</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2021-09-16 03:48:34', '2021-09-16 03:48:34', '', 0, 'http://localhost/wordpress_581/?page_id=3', 0, 'page', '', 0),
(10, 1, '2021-09-22 14:21:57', '2021-09-22 14:21:57', '<!-- wp:paragraph -->\n<p>ANHDùng đội hình hai và không đăng ký siêu sao Cristiano Ronaldo, Man Utd thua đội khách West Ham 0-1 ở vòng ba Cup Liên đoàn tối 22/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Ghi bàn: Lanzini 9</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Khi trận đấu chỉ còn tính bằng giây và Man Utd bị dẫn 0-1, HLV Ole Gunnar Solskjaer vẫn cười đùa với đồng nghiệp David Moyes sau một tình huống trên sân. Man Utd bị loại khỏi Cup Liên đoàn, khiến họ mất thêm một cơ hội chấm dứt chuỗi năm năm trắng tay.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tung ra sân đội hình hai khiến Man Utd sớm thủng lưới. Phút thứ chín, hậu vệ phải Ryan Fredericks bất ngờ dốc bóng vượt qua Alex Telles, rồi chuyền ngược ra cho Manuel Lanzini đệm bóng sệt về góc xa. West Ham lại dẫn trước giống như cuộc đối đầu giữa hai đội ở Ngoại hạng Anh hôm 19/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/23/man-utd-jpeg-1632341093-5239-1632341394.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=69njs_PCX-QZsiIyrIhCMg\" alt=\"Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh: REX\"/><figcaption>Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh:&nbsp;<em>REX</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Bàn thua này khiến Man Utd phải đẩy cao tốc độ, và tạo ra vài cơ hội. Đáng kể là tình huống trọng tài Jon Moss từ chối phạt đền cho Man Utd, khi Mark Noble kéo ngã Jesse Lingard trong cấm địa. Không lâu sau, Juan Mata sút dội xà ngang sau tình huống lập bập trong cấm địa. Chủ nhà dứt điểm 13 quả trong hiệp một, hơn gấp ba lần so với West Ham.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer phải đưa các cầu thủ chính thức vào sân ở hiệp hai, đầu tiên là Mason Greenwood ở phút 62. Chỉ sau hơn 10 giây trên sân, Greenwood có cơ hội đối mặt sau đường chuyền của Donny van de Beek ra sau hàng thủ West Ham. Nhưng Greenwood sút không trúng tâm bóng, bị thủ môn Alphonse Areola dùng chân phá.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Mười phút sau, đến lượt Bruno Fernandes và tiền vệ trẻ Anthony Elanga vào sân, nhưng không tạo được dấu ấn. Man Utd vẫn có thêm vài cơ hội nhưng phung phí. Phút 81, từ cú sút xa của Jadon Sancho, bóng đổi hướng giúp Anthony Martial đối mặt thủ môn. Nhưng, trong ngày chơi xuất thần, thủ môn Areola lao ra kịp thời để chắn cú sút của Martial.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer không đăng ký Cristiano Ronaldo, Paul Pogba hay Harry Maguire cho trận này, khiến Man Utd cũng hết phương án thay đổi nhân sự. Họ thậm chí suýt thủng thêm bàn ở phút 86, khi Yarmolenko sút trúng cột dọc sau một pha phản công. Hai phút sau, đến lượt đội trưởng Noble bỏ lỡ cơ hội đối mặt thuận lợi cũng từ pha bóng hai đánh một.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Man Utd chỉ còn chơi ở ba đấu trường mùa này, gồm Ngoại hạng Anh, Cup FA và Champions League, trong đó Cup FA bắt đầu thi đấu từ đầu năm 2022. Ở trận tiếp theo, Man Utd tiếp Aston Villa trên sân Old Trafford ở vòng sáu Ngoại hạng Anh thứ bảy 25/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><strong>Danh sách thi đấu</strong></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Man Utd</em>: Henderson, Dalot, Lindelof, Bailly, Alex Telles (Elanga 72), Mata (Greenwood 62), Matic, van de Beek, Sancho, Martial, Lingard (Fernandes 72).</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>West Ham</em>: Areola, Johnson, Dawson, Diop, Fredericks (Coufal 17), Noble, Kral, Yarmolenko, Lanzini (Fornals 69), Masuaku (Vlasic 69), Bowen.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:list -->\n<ul><li>List 1</li><li>List 2</li></ul>\n<!-- /wp:list -->', 'Man Utd bị loại khỏi Cup Liên đoàn', '', 'publish', 'open', 'open', '', 'test1', '', '', '2021-09-22 22:11:50', '2021-09-22 22:11:50', '', 0, 'http://localhost/wordpress_581/?p=10', 0, 'post', '', 0),
(11, 1, '2021-09-22 14:21:57', '2021-09-22 14:21:57', '<!-- wp:paragraph -->\n<p>Test1</p>\n<!-- /wp:paragraph -->', 'Test1', '', 'inherit', 'closed', 'closed', '', '10-revision-v1', '', '', '2021-09-22 14:21:57', '2021-09-22 14:21:57', '', 10, 'http://localhost/wordpress_581/?p=11', 0, 'revision', '', 0),
(12, 1, '2021-09-22 14:23:40', '2021-09-22 14:23:40', '<!-- wp:paragraph -->\n<p>About page 1</p>\n<!-- /wp:paragraph -->', 'About page 1', '', 'publish', 'closed', 'closed', '', 'about-page-1', '', '', '2021-09-22 14:23:40', '2021-09-22 14:23:40', '', 0, 'http://localhost/wordpress_581/?page_id=12', 0, 'page', '', 0),
(14, 1, '2021-09-22 14:23:40', '2021-09-22 14:23:40', '<!-- wp:paragraph -->\n<p>About page 1</p>\n<!-- /wp:paragraph -->', 'About page 1', '', 'inherit', 'closed', 'closed', '', '12-revision-v1', '', '', '2021-09-22 14:23:40', '2021-09-22 14:23:40', '', 12, 'http://localhost/wordpress_581/?p=14', 0, 'revision', '', 0),
(15, 1, '2021-09-22 22:06:16', '2021-09-22 22:06:16', '', 'messi-0650 (1)', '', 'inherit', 'open', 'closed', '', 'messi-0650-1', '', '', '2021-09-22 22:06:16', '2021-09-22 22:06:16', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-0650-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(16, 1, '2021-09-22 22:06:18', '2021-09-22 22:06:18', '', 'messi-0650', '', 'inherit', 'open', 'closed', '', 'messi-0650', '', '', '2021-09-22 22:06:18', '2021-09-22 22:06:18', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-0650.jpg', 0, 'attachment', 'image/jpeg', 0),
(17, 1, '2021-09-22 22:06:19', '2021-09-22 22:06:19', '', 'messi-chan-thuong-1', '', 'inherit', 'open', 'closed', '', 'messi-chan-thuong-1', '', '', '2021-09-22 22:06:19', '2021-09-22 22:06:19', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-chan-thuong-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(18, 1, '2021-09-22 22:06:20', '2021-09-22 22:06:20', '', 'psg', '', 'inherit', 'open', 'closed', '', 'psg', '', '', '2021-09-22 22:06:20', '2021-09-22 22:06:20', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/psg.jpeg', 0, 'attachment', 'image/jpeg', 0),
(19, 1, '2021-09-22 22:06:21', '2021-09-22 22:06:21', '', 'psg-gap-hoa-lon-voi-lionel-messi', '', 'inherit', 'open', 'closed', '', 'psg-gap-hoa-lon-voi-lionel-messi', '', '', '2021-09-22 22:06:21', '2021-09-22 22:06:21', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/psg-gap-hoa-lon-voi-lionel-messi.jpg', 0, 'attachment', 'image/jpeg', 0),
(20, 1, '2021-09-22 22:06:22', '2021-09-22 22:06:22', '', 'download', '', 'inherit', 'open', 'closed', '', 'download', '', '', '2021-09-22 22:06:22', '2021-09-22 22:06:22', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/download.jpg', 0, 'attachment', 'image/jpeg', 0),
(21, 1, '2021-09-22 22:06:22', '2021-09-22 22:06:22', '', 'koeman-messi-la-mot-bao-chua-tren-san-tap', '', 'inherit', 'open', 'closed', '', 'koeman-messi-la-mot-bao-chua-tren-san-tap', '', '', '2021-09-22 22:06:22', '2021-09-22 22:06:22', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap.jpg', 0, 'attachment', 'image/jpeg', 0),
(22, 1, '2021-09-22 22:06:23', '2021-09-22 22:06:23', '', 'Lionel_Messi_20180626', '', 'inherit', 'open', 'closed', '', 'lionel_messi_20180626', '', '', '2021-09-22 22:06:23', '2021-09-22 22:06:23', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/Lionel_Messi_20180626.jpg', 0, 'attachment', 'image/jpeg', 0),
(23, 1, '2021-09-22 22:06:23', '2021-09-22 22:06:23', '', 'messi_cies', '', 'inherit', 'open', 'closed', '', 'messi_cies', '', '', '2021-09-22 22:06:23', '2021-09-22 22:06:23', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi_cies.jpeg', 0, 'attachment', 'image/jpeg', 0),
(24, 1, '2021-09-22 22:06:24', '2021-09-22 22:06:24', '', 'messi_lyld', '', 'inherit', 'open', 'closed', '', 'messi_lyld', '', '', '2021-09-22 22:06:24', '2021-09-22 22:06:24', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi_lyld.jpeg', 0, 'attachment', 'image/jpeg', 0),
(25, 1, '2021-09-22 22:06:25', '2021-09-22 22:06:25', '', 'messi-0650', '', 'inherit', 'open', 'closed', '', 'messi-0650-2', '', '', '2021-09-22 22:06:25', '2021-09-22 22:06:25', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-0650-2.jpg', 0, 'attachment', 'image/jpeg', 0),
(26, 1, '2021-09-22 22:06:26', '2021-09-22 22:06:26', '', 'messi-chan-thuong-1', '', 'inherit', 'open', 'closed', '', 'messi-chan-thuong-1-2', '', '', '2021-09-22 22:06:26', '2021-09-22 22:06:26', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-chan-thuong-1-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(27, 1, '2021-09-22 22:06:27', '2021-09-22 22:06:27', '', 'psg', '', 'inherit', 'open', 'closed', '', 'psg-2', '', '', '2021-09-22 22:06:27', '2021-09-22 22:06:27', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/psg-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(28, 1, '2021-09-22 22:06:28', '2021-09-22 22:06:28', '', 'psg-gap-hoa-lon-voi-lionel-messi', '', 'inherit', 'open', 'closed', '', 'psg-gap-hoa-lon-voi-lionel-messi-2', '', '', '2021-09-22 22:06:28', '2021-09-22 22:06:28', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/psg-gap-hoa-lon-voi-lionel-messi-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(29, 1, '2021-09-22 22:06:28', '2021-09-22 22:06:28', '', 'download', '', 'inherit', 'open', 'closed', '', 'download-2', '', '', '2021-09-22 22:06:28', '2021-09-22 22:06:28', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/download-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(30, 1, '2021-09-22 22:06:29', '2021-09-22 22:06:29', '', 'koeman-messi-la-mot-bao-chua-tren-san-tap', '', 'inherit', 'open', 'closed', '', 'koeman-messi-la-mot-bao-chua-tren-san-tap-2', '', '', '2021-09-22 22:06:29', '2021-09-22 22:06:29', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/koeman-messi-la-mot-bao-chua-tren-san-tap-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(31, 1, '2021-09-22 22:06:29', '2021-09-22 22:06:29', '', 'Lionel_Messi_20180626', '', 'inherit', 'open', 'closed', '', 'lionel_messi_20180626-2', '', '', '2021-09-22 22:06:29', '2021-09-22 22:06:29', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/Lionel_Messi_20180626-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(32, 1, '2021-09-22 22:06:30', '2021-09-22 22:06:30', '', 'messi_cies', '', 'inherit', 'open', 'closed', '', 'messi_cies-2', '', '', '2021-09-22 22:06:30', '2021-09-22 22:06:30', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi_cies-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(33, 1, '2021-09-22 22:06:30', '2021-09-22 22:06:30', '', 'messi_lyld', '', 'inherit', 'open', 'closed', '', 'messi_lyld-2', '', '', '2021-09-22 22:06:30', '2021-09-22 22:06:30', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi_lyld-1.jpeg', 0, 'attachment', 'image/jpeg', 0),
(34, 1, '2021-09-22 22:06:31', '2021-09-22 22:06:31', '', 'messi-0650 (1)', '', 'inherit', 'open', 'closed', '', 'messi-0650-1-2', '', '', '2021-09-22 22:06:31', '2021-09-22 22:06:31', '', 0, 'http://localhost/wordpress_581/wp-content/uploads/2021/09/messi-0650-1-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(35, 1, '2021-09-22 22:07:49', '2021-09-22 22:07:49', '<!-- wp:paragraph -->\n<p><em>Ghi bàn: Đắc Huy 18, Đức Hoà 39 - Robinho 11, Chishkala 18, 30</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Năm năm trước tại Colombia, Nga thắng Việt Nam tới 7-0 cũng ở vòng 1/8 futsal World Cup, nhưng lần này tình thế đã thay đổi. Ở Vilnius tối 22/9, Nga không có lúc nào tạo được cách biệt ba bàn trước Việt Nam. Thầy trò Phạm Minh Giang thậm chí ghi được hai bàn nhờ công của pivot Nguyễn Đắc Huy và hậu vệ Phạm Đức Hoà. Nhưng, Nga vẫn đi tiếp vào tứ kết nhờ bàn thắng của Robinho và cú đúp cho Ivan Chishkala.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/da-c-huy-jpeg-1632328254-5170-1632328316.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=6Ba7xTBALBjafsR5w4ziVw\" alt=\"Đắc Huy (phải) mừng bàn sau khi đánh đầu nối từ đường chuyền bằng đầu của Gia Hưng (trái). Ảnh: VFF\"/><figcaption>Đắc Huy (phải) mừng bàn sau khi đánh đầu nối từ đường chuyền bằng đầu của Gia Hưng (trái). Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Không bất ngờ khi Việt Nam chọn lối chơi phòng ngự phản công quen thuộc, khi đội chỉ giữ bóng 28% thời lượng hiệp một. Đoàn quân của Minh Giang đứng vững trong 10 phút đầu tiên, nhờ vào ít nhất năm pha cứu thua đẹp mắt của thủ môn Hồ Văn Ý. Anh liên tục bay người, chuồi xuống, vươn tay phá bóng hay thậm chí dùng thân mình để ngăn cú sút của đối phương.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đến phút 11, Nga bất ngờ thay đổi chiến thuật, bằng cách cắm ba cầu thủ vào cấm địa Việt Nam và để Robinho cầm bóng qua người. Tiền vệ 38 tuổi gốc Brazil vượt qua Văn Hoà bên phải, chuyền vào cho Afanasev làm tường. Lúc này thủ môn Văn Ý phải lao ra để làm hẹp góc sút, nhưng Afanasev lại gạt sang cho Robinho đệm vào khung thành trống để mở tỷ số.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/hoa-jpeg-1632328178-1632328196-9087-1632328316.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=qJ_yq9Bx9r38FLAdxsJ15g\" alt=\"Tình huống Robinho (trái) vượt qua Đức Hoà trước khi ghi bàn. Ảnh: VFF\"/><figcaption>Tình huống Robinho (trái) vượt qua Đức Hoà trước khi ghi bàn. Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Robinho sau khi ghi bàn, ra sân nghỉ vài phút. Sau khi trở lại, anh đá biên cho Chishkala sút một chạm đưa bóng đi qua hai chân thủ môn Văn Ý, rồi lăn vào lưới. Nga dẫn 2-0 khi hiệp một chỉ còn hai phút. Hai cầu thủ này được coi là cặp bài trùng của Nga, khi cùng chơi cho CLB Benfica ở Bồ Đào Nha.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nhưng thế dẫn hai bàn của Nga chỉ tồn tại vài giây, khi Việt Nam rút ngắn tỷ số chóng vánh. Thủ môn Văn Ý chuyền dài lên cho Gia Hưng đánh đầu vào cấm địa. Đắc Huy ập vào đánh đầu nối cận thành hạ gục thủ môn Putilov. Sau khi ghi bàn, Đắc Huy giơ áo số 10 của pivot Nguyễn Đức Tùng lên, để tri ân cầu thủ này bị chấn thương đầu gối nặng từ trận cuối vòng bảng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nga không chấp nhận thắng cách biệt một bàn, mà dồn lên tấn công đầu hiệp hai. Sau khi Artem Niyazov và Sergei Abramov sút trúng cột dọc liên tiếp, đoàn quân của HLV Sergey Skorovich cũng ghi được bàn thứ ba. Lại là Robinho chuyền bóng để Chishkala xử lý ngoài cấm địa. Chishkala rê bóng xuống biên trái, vượt qua Minh Trí, rồi sút chìm chéo góc hạ gục thủ môn Văn Ý. Đây là bàn thứ năm của anh tại giải, còn Robinho có tình huống thứ tám ghi dấu giày vào bàn thắng.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Nhưng, Việt Nam vẫn không nản chí để tìm bàn gỡ thêm. Sau khi tiền vệ trẻ Nguyễn Văn Hiếu đệm bóng chệch cột, Việt Nam chuyển sang chơi power-play. Từ một tình huống như thế ở phút 39, đội trưởng Trần Văn Vũ cướp bóng trong chân Ivan Milovanov ngay rìa cấm địa Nga. Đức Hoà đứng ngay cạnh, thúc mũi giày đưa bóng đi căng và tung lưới Nga, khi thủ môn Dmitri Putilov không kịp trở tay.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/22/duc-hoa-jpeg-7043-1632329313.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=CkKk4i9PRTWjWJiTJDAD5w\" alt=\"Việt Nam (áo đỏ) dừng bước ở vòng 1/8, lần thứ hai liên tiếp. Ảnh: VFF\"/><figcaption>Việt Nam (áo đỏ) dừng bước ở vòng 1/8, lần thứ hai liên tiếp. Ảnh:&nbsp;<em>VFF</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Với cách biệt chỉ còn một bàn, Việt Nam tất tay để tìm bàn gỡ hoà nhằm đưa trận đấu vào hiệp phụ. Nhưng, cơ hội cuối của Minh Trí không thể thành bàn, khi anh sút từ góc hẹp suýt qua được hai chân thủ môn Nga.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Trận thua sát nút 2-3 cũng là kết quả nằm ngoài dự đoán, cho thấy Việt Nam phần nào đã tiến bộ so với lần đầu dự futsal World Cup năm 2016. Tỷ số này cũng là bất ngờ khi Nga đang hơn Việt Nam 35 bậc thế giới. Nga sẽ vào tứ kết gặp đương kim vô địch Argentina hoặc Paraguay.</p>\n<!-- /wp:paragraph -->', 'Việt Nam thua sát Nga ở vòng 1/8 futsal World Cup', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2021-09-22 22:07:49', '2021-09-22 22:07:49', '', 1, 'http://localhost/wordpress_581/?p=35', 0, 'revision', '', 0),
(36, 1, '2021-09-22 22:09:49', '2021-09-22 22:09:49', '<!-- wp:paragraph -->\n<p>ANHDùng đội hình hai và không đăng ký siêu sao Cristiano Ronaldo, Man Utd thua đội khách West Ham 0-1 ở vòng ba Cup Liên đoàn tối 22/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Ghi bàn: Lanzini 9</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Khi trận đấu chỉ còn tính bằng giây và Man Utd bị dẫn 0-1, HLV Ole Gunnar Solskjaer vẫn cười đùa với đồng nghiệp David Moyes sau một tình huống trên sân. Man Utd bị loại khỏi Cup Liên đoàn, khiến họ mất thêm một cơ hội chấm dứt chuỗi năm năm trắng tay.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tung ra sân đội hình hai khiến Man Utd sớm thủng lưới. Phút thứ chín, hậu vệ phải Ryan Fredericks bất ngờ dốc bóng vượt qua Alex Telles, rồi chuyền ngược ra cho Manuel Lanzini đệm bóng sệt về góc xa. West Ham lại dẫn trước giống như cuộc đối đầu giữa hai đội ở Ngoại hạng Anh hôm 19/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/23/man-utd-jpeg-1632341093-5239-1632341394.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=69njs_PCX-QZsiIyrIhCMg\" alt=\"Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh: REX\"/><figcaption>Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh:&nbsp;<em>REX</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Bàn thua này khiến Man Utd phải đẩy cao tốc độ, và tạo ra vài cơ hội. Đáng kể là tình huống trọng tài Jon Moss từ chối phạt đền cho Man Utd, khi Mark Noble kéo ngã Jesse Lingard trong cấm địa. Không lâu sau, Juan Mata sút dội xà ngang sau tình huống lập bập trong cấm địa. Chủ nhà dứt điểm 13 quả trong hiệp một, hơn gấp ba lần so với West Ham.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer phải đưa các cầu thủ chính thức vào sân ở hiệp hai, đầu tiên là Mason Greenwood ở phút 62. Chỉ sau hơn 10 giây trên sân, Greenwood có cơ hội đối mặt sau đường chuyền của Donny van de Beek ra sau hàng thủ West Ham. Nhưng Greenwood sút không trúng tâm bóng, bị thủ môn Alphonse Areola dùng chân phá.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Mười phút sau, đến lượt Bruno Fernandes và tiền vệ trẻ Anthony Elanga vào sân, nhưng không tạo được dấu ấn. Man Utd vẫn có thêm vài cơ hội nhưng phung phí. Phút 81, từ cú sút xa của Jadon Sancho, bóng đổi hướng giúp Anthony Martial đối mặt thủ môn. Nhưng, trong ngày chơi xuất thần, thủ môn Areola lao ra kịp thời để chắn cú sút của Martial.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer không đăng ký Cristiano Ronaldo, Paul Pogba hay Harry Maguire cho trận này, khiến Man Utd cũng hết phương án thay đổi nhân sự. Họ thậm chí suýt thủng thêm bàn ở phút 86, khi Yarmolenko sút trúng cột dọc sau một pha phản công. Hai phút sau, đến lượt đội trưởng Noble bỏ lỡ cơ hội đối mặt thuận lợi cũng từ pha bóng hai đánh một.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Man Utd chỉ còn chơi ở ba đấu trường mùa này, gồm Ngoại hạng Anh, Cup FA và Champions League, trong đó Cup FA bắt đầu thi đấu từ đầu năm 2022. Ở trận tiếp theo, Man Utd tiếp Aston Villa trên sân Old Trafford ở vòng sáu Ngoại hạng Anh thứ bảy 25/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><strong>Danh sách thi đấu</strong></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Man Utd</em>: Henderson, Dalot, Lindelof, Bailly, Alex Telles (Elanga 72), Mata (Greenwood 62), Matic, van de Beek, Sancho, Martial, Lingard (Fernandes 72).</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>West Ham</em>: Areola, Johnson, Dawson, Diop, Fredericks (Coufal 17), Noble, Kral, Yarmolenko, Lanzini (Fornals 69), Masuaku (Vlasic 69), Bowen.</p>\n<!-- /wp:paragraph -->', 'Man Utd bị loại khỏi Cup Liên đoàn', '', 'inherit', 'closed', 'closed', '', '10-revision-v1', '', '', '2021-09-22 22:09:49', '2021-09-22 22:09:49', '', 10, 'http://localhost/wordpress_581/?p=36', 0, 'revision', '', 0),
(37, 1, '2021-09-22 22:10:32', '2021-09-22 22:10:32', '<!-- wp:paragraph -->\n<p>HLV Ole Solskjaer bác bỏ luận điểm của cựu trung vệ Rio Ferdinand về việc Cristiano Ronaldo đứng ngoài đường biên hô hào trong trận đấu Young Boys tại Champions League.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>*West Ham - Man Utd: 20h Chủ nhật 19/9, trên VnExpress</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"Rio, một lần nữa các bạn biết đấy, đôi khi anh ấy bình luận về những điều mà anh ấy không thực sự nắm rõ. Trong tình huống đó, lẽ ra trọng tài phải phạt thẻ vàng Christopher Martins khi cậu ta kéo ngã Nemanja Matic. Bruno Fernandes và Cristiano Ronaldo đều là những cầu thủ giàu tinh thần cạnh tranh. Họ đứng lên trong một khoảng thời gian ngắn và hét lên với trọng tài. Đó chỉ là sự bực tức khi phải nhận một số quyết định tồi. Sau đó, họ đều ngồi xuống\", Solskjaer nói trong họp báo trước trận West Ham ở vòng 5 Ngoại hạng Anh.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/19/rona-4306-1632021564.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=EjxcLFXhfj8RgFzMxGkAGA\" alt=\"Ronaldo và Fernandes chạy ra đường biên cùng Solskjaer phản đối trọng tài. Ảnh: EPA.\"/><figcaption>Ronaldo và Fernandes chạy ra đường biên cùng HLV Solskjaer phản đối trọng tài. Ảnh:&nbsp;<em>EPA</em>.</figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Trong trận đấu Young Boys ở lượt ra quân Champions League hôm giữa tuần, Martins phải nhận thẻ vàng ở phút 50. Nếu nhận thêm thẻ trong tình huống kéo ngã Matic ở phút 80, tiền vệ đội chủ nhà sẽ phải rời sân và hai đội cân băng về lực lượng. Trước đó, Man Utd mất Aaron Wan-Bissaka từ phút 35.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Khi trọng tài từ chối phạt thêm thẻ với Martins, Ronaldo và Fernandes đều bức xúc. Cả hai - vốn đã rời sân tám phút trước đó - đều bật dậy và chạy ra phản đối cùng Solskjaer. Tuy nhiên, trong chương trình bình luận, Ferdinand coi hành động của Ronaldo là&nbsp;<a href=\"https://vnexpress.net/ferdinand-khong-muon-ronaldo-thay-solskjaer-chi-dao-4357419.html\">chỉ đạo các cầu thủ</a>&nbsp;thay HLV. Cựu trung vệ người Anh còn nói: \"Nếu tôi là HLV, thành thật mà nói, tôi sẽ bảo Ronaldo ngồi xuống\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>HLV Solskjaer giải thích thêm: \"\"Trong khu vực chỉ đạo chỉ có một người được tham gia, đó là tôi, Michael Carrick, Mick Phelan, hoặc Kieran McKenna. Hành động của Ronaldo và Fernandes chỉ là bột phát, khi cầu thủ đối phương lẽ ra phải nhận thẻ vàng thứ hai. Tôi không có vấn đề gì với việc họ thể hiện cảm xúc và sau đó quay lại chỗ ngồi. Nó không giống như Ronaldo đang chỉ đạo các cầu thủ\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Do thi đấu hơn người trong hai phần ba thời gian, Young Boys chơi lấn lướt và&nbsp;<a href=\"https://vnexpress.net/young-boys-2-1-man-utd-4356603.html\">ngược dòng</a>&nbsp;bằng hai bàn của Ngamaleu phút 66 và Siebatcheu phút 90+5. Trước đó, Ronaldo mở tỷ số cho Man Utd phút 13.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đây không phải là lần đầu tiên Ronaldo gây tranh cãi vì hành động trong khu vực dành cho HLV. Trong trận chung kết Euro 2016, sau khi chấn thương rời sân, anh liên tục đứng lên hô hào các đồng đội, bên cạnh HLV Fernando Santos.</p>\n<!-- /wp:paragraph -->', 'Solskjaer: \'Ronaldo không chỉ đạo cầu thủ Man Utd\'', '', 'publish', 'open', 'open', '', 'solskjaer-ronaldo-khong-chi-dao-cau-thu-man-utd', '', '', '2021-09-22 22:10:47', '2021-09-22 22:10:47', '', 0, 'http://localhost/wordpress_581/?p=37', 0, 'post', '', 0),
(38, 1, '2021-09-22 22:10:32', '2021-09-22 22:10:32', '<!-- wp:paragraph -->\n<p>HLV Ole Solskjaer bác bỏ luận điểm của cựu trung vệ Rio Ferdinand về việc Cristiano Ronaldo đứng ngoài đường biên hô hào trong trận đấu Young Boys tại Champions League.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>*West Ham - Man Utd: 20h Chủ nhật 19/9, trên VnExpress</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>\"Rio, một lần nữa các bạn biết đấy, đôi khi anh ấy bình luận về những điều mà anh ấy không thực sự nắm rõ. Trong tình huống đó, lẽ ra trọng tài phải phạt thẻ vàng Christopher Martins khi cậu ta kéo ngã Nemanja Matic. Bruno Fernandes và Cristiano Ronaldo đều là những cầu thủ giàu tinh thần cạnh tranh. Họ đứng lên trong một khoảng thời gian ngắn và hét lên với trọng tài. Đó chỉ là sự bực tức khi phải nhận một số quyết định tồi. Sau đó, họ đều ngồi xuống\", Solskjaer nói trong họp báo trước trận West Ham ở vòng 5 Ngoại hạng Anh.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/19/rona-4306-1632021564.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=EjxcLFXhfj8RgFzMxGkAGA\" alt=\"Ronaldo và Fernandes chạy ra đường biên cùng Solskjaer phản đối trọng tài. Ảnh: EPA.\"/><figcaption>Ronaldo và Fernandes chạy ra đường biên cùng HLV Solskjaer phản đối trọng tài. Ảnh:&nbsp;<em>EPA</em>.</figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Trong trận đấu Young Boys ở lượt ra quân Champions League hôm giữa tuần, Martins phải nhận thẻ vàng ở phút 50. Nếu nhận thêm thẻ trong tình huống kéo ngã Matic ở phút 80, tiền vệ đội chủ nhà sẽ phải rời sân và hai đội cân băng về lực lượng. Trước đó, Man Utd mất Aaron Wan-Bissaka từ phút 35.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Khi trọng tài từ chối phạt thêm thẻ với Martins, Ronaldo và Fernandes đều bức xúc. Cả hai - vốn đã rời sân tám phút trước đó - đều bật dậy và chạy ra phản đối cùng Solskjaer. Tuy nhiên, trong chương trình bình luận, Ferdinand coi hành động của Ronaldo là&nbsp;<a href=\"https://vnexpress.net/ferdinand-khong-muon-ronaldo-thay-solskjaer-chi-dao-4357419.html\">chỉ đạo các cầu thủ</a>&nbsp;thay HLV. Cựu trung vệ người Anh còn nói: \"Nếu tôi là HLV, thành thật mà nói, tôi sẽ bảo Ronaldo ngồi xuống\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>HLV Solskjaer giải thích thêm: \"\"Trong khu vực chỉ đạo chỉ có một người được tham gia, đó là tôi, Michael Carrick, Mick Phelan, hoặc Kieran McKenna. Hành động của Ronaldo và Fernandes chỉ là bột phát, khi cầu thủ đối phương lẽ ra phải nhận thẻ vàng thứ hai. Tôi không có vấn đề gì với việc họ thể hiện cảm xúc và sau đó quay lại chỗ ngồi. Nó không giống như Ronaldo đang chỉ đạo các cầu thủ\".</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Do thi đấu hơn người trong hai phần ba thời gian, Young Boys chơi lấn lướt và&nbsp;<a href=\"https://vnexpress.net/young-boys-2-1-man-utd-4356603.html\">ngược dòng</a>&nbsp;bằng hai bàn của Ngamaleu phút 66 và Siebatcheu phút 90+5. Trước đó, Ronaldo mở tỷ số cho Man Utd phút 13.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Đây không phải là lần đầu tiên Ronaldo gây tranh cãi vì hành động trong khu vực dành cho HLV. Trong trận chung kết Euro 2016, sau khi chấn thương rời sân, anh liên tục đứng lên hô hào các đồng đội, bên cạnh HLV Fernando Santos.</p>\n<!-- /wp:paragraph -->', 'Solskjaer: \'Ronaldo không chỉ đạo cầu thủ Man Utd\'', '', 'inherit', 'closed', 'closed', '', '37-revision-v1', '', '', '2021-09-22 22:10:32', '2021-09-22 22:10:32', '', 37, 'http://localhost/wordpress_581/?p=38', 0, 'revision', '', 0),
(39, 1, '2021-09-22 22:11:50', '2021-09-22 22:11:50', '<!-- wp:paragraph -->\n<p>ANHDùng đội hình hai và không đăng ký siêu sao Cristiano Ronaldo, Man Utd thua đội khách West Ham 0-1 ở vòng ba Cup Liên đoàn tối 22/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Ghi bàn: Lanzini 9</em></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Khi trận đấu chỉ còn tính bằng giây và Man Utd bị dẫn 0-1, HLV Ole Gunnar Solskjaer vẫn cười đùa với đồng nghiệp David Moyes sau một tình huống trên sân. Man Utd bị loại khỏi Cup Liên đoàn, khiến họ mất thêm một cơ hội chấm dứt chuỗi năm năm trắng tay.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Tung ra sân đội hình hai khiến Man Utd sớm thủng lưới. Phút thứ chín, hậu vệ phải Ryan Fredericks bất ngờ dốc bóng vượt qua Alex Telles, rồi chuyền ngược ra cho Manuel Lanzini đệm bóng sệt về góc xa. West Ham lại dẫn trước giống như cuộc đối đầu giữa hai đội ở Ngoại hạng Anh hôm 19/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:image -->\n<figure class=\"wp-block-image\"><img src=\"https://i1-thethao.vnecdn.net/2021/09/23/man-utd-jpeg-1632341093-5239-1632341394.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=69njs_PCX-QZsiIyrIhCMg\" alt=\"Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh: REX\"/><figcaption>Man Utd (áo đỏ) nhập cuộc không tốt và sớm bị dẫn trước. Ảnh:&nbsp;<em>REX</em></figcaption></figure>\n<!-- /wp:image -->\n\n<!-- wp:paragraph -->\n<p>Bàn thua này khiến Man Utd phải đẩy cao tốc độ, và tạo ra vài cơ hội. Đáng kể là tình huống trọng tài Jon Moss từ chối phạt đền cho Man Utd, khi Mark Noble kéo ngã Jesse Lingard trong cấm địa. Không lâu sau, Juan Mata sút dội xà ngang sau tình huống lập bập trong cấm địa. Chủ nhà dứt điểm 13 quả trong hiệp một, hơn gấp ba lần so với West Ham.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer phải đưa các cầu thủ chính thức vào sân ở hiệp hai, đầu tiên là Mason Greenwood ở phút 62. Chỉ sau hơn 10 giây trên sân, Greenwood có cơ hội đối mặt sau đường chuyền của Donny van de Beek ra sau hàng thủ West Ham. Nhưng Greenwood sút không trúng tâm bóng, bị thủ môn Alphonse Areola dùng chân phá.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Mười phút sau, đến lượt Bruno Fernandes và tiền vệ trẻ Anthony Elanga vào sân, nhưng không tạo được dấu ấn. Man Utd vẫn có thêm vài cơ hội nhưng phung phí. Phút 81, từ cú sút xa của Jadon Sancho, bóng đổi hướng giúp Anthony Martial đối mặt thủ môn. Nhưng, trong ngày chơi xuất thần, thủ môn Areola lao ra kịp thời để chắn cú sút của Martial.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Solskjaer không đăng ký Cristiano Ronaldo, Paul Pogba hay Harry Maguire cho trận này, khiến Man Utd cũng hết phương án thay đổi nhân sự. Họ thậm chí suýt thủng thêm bàn ở phút 86, khi Yarmolenko sút trúng cột dọc sau một pha phản công. Hai phút sau, đến lượt đội trưởng Noble bỏ lỡ cơ hội đối mặt thuận lợi cũng từ pha bóng hai đánh một.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Man Utd chỉ còn chơi ở ba đấu trường mùa này, gồm Ngoại hạng Anh, Cup FA và Champions League, trong đó Cup FA bắt đầu thi đấu từ đầu năm 2022. Ở trận tiếp theo, Man Utd tiếp Aston Villa trên sân Old Trafford ở vòng sáu Ngoại hạng Anh thứ bảy 25/9.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><strong>Danh sách thi đấu</strong></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>Man Utd</em>: Henderson, Dalot, Lindelof, Bailly, Alex Telles (Elanga 72), Mata (Greenwood 62), Matic, van de Beek, Sancho, Martial, Lingard (Fernandes 72).</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><em>West Ham</em>: Areola, Johnson, Dawson, Diop, Fredericks (Coufal 17), Noble, Kral, Yarmolenko, Lanzini (Fornals 69), Masuaku (Vlasic 69), Bowen.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:list -->\n<ul><li>List 1</li><li>List 2</li></ul>\n<!-- /wp:list -->', 'Man Utd bị loại khỏi Cup Liên đoàn', '', 'inherit', 'closed', 'closed', '', '10-revision-v1', '', '', '2021-09-22 22:11:50', '2021-09-22 22:11:50', '', 10, 'http://localhost/wordpress_581/?p=39', 0, 'revision', '', 0),
(40, 1, '2021-09-22 22:18:30', '2021-09-22 22:14:13', ' ', '', '', 'publish', 'closed', 'closed', '', '40', '', '', '2021-09-22 22:18:30', '2021-09-22 22:18:30', '', 0, 'http://localhost/wordpress_581/?p=40', 1, 'nav_menu_item', '', 0),
(41, 1, '2021-09-22 22:18:30', '2021-09-22 22:14:13', ' ', '', '', 'publish', 'closed', 'closed', '', '41', '', '', '2021-09-22 22:18:30', '2021-09-22 22:18:30', '', 0, 'http://localhost/wordpress_581/?p=41', 2, 'nav_menu_item', '', 0),
(42, 1, '2021-09-22 22:14:38', '0000-00-00 00:00:00', '', 'Test', '', 'draft', 'closed', 'closed', '', '', '', '', '2021-09-22 22:14:38', '0000-00-00 00:00:00', '', 0, 'http://localhost/wordpress_581/?p=42', 1, 'nav_menu_item', '', 0),
(43, 1, '2021-09-22 22:14:46', '0000-00-00 00:00:00', '', 'test2', '', 'draft', 'closed', 'closed', '', '', '', '', '2021-09-22 22:14:46', '0000-00-00 00:00:00', '', 0, 'http://localhost/wordpress_581/?p=43', 1, 'nav_menu_item', '', 0),
(44, 1, '2021-09-22 22:18:30', '2021-09-22 22:16:08', '', 'Solskjaer: ‘Ronaldo không chỉ đạo cầu thủ Man Utd’', '', 'publish', 'closed', 'closed', '', 'solskjaer-ronaldo-khong-chi-dao-cau-thu-man-utd', '', '', '2021-09-22 22:18:30', '2021-09-22 22:18:30', '', 0, 'http://localhost/wordpress_581/?p=44', 3, 'nav_menu_item', '', 0),
(45, 1, '2021-09-22 22:18:30', '2021-09-22 22:18:30', '', 'test', '', 'publish', 'closed', 'closed', '', 'test', '', '', '2021-09-22 22:18:30', '2021-09-22 22:18:30', '', 0, 'http://localhost/wordpress_581/?p=45', 4, 'nav_menu_item', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Danh mục khác', 'danh-muc-khac', 0),
(2, 'Bóng đá', 'bong-da', 0),
(3, 'Tennis', 'tennis', 0),
(4, 'World Cup 2022', 'world-cup', 0),
(5, 'Billars', 'billar', 0),
(6, 'UEFA', 'uefa', 0),
(7, 'C1', 'c1', 0),
(8, 'C2', 'c2', 0),
(9, 'Bóng đá', 'bong-da', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 2, 0),
(10, 1, 0),
(37, 1, 0),
(37, 6, 0),
(37, 7, 0),
(37, 8, 0),
(40, 9, 0),
(41, 9, 0),
(44, 9, 0),
(45, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 2),
(2, 2, 'category', '', 0, 1),
(3, 3, 'category', '', 0, 0),
(4, 4, 'category', '', 0, 0),
(5, 5, 'category', '', 0, 0),
(6, 6, 'category', 'UEFA', 2, 1),
(7, 7, 'category', '', 2, 1),
(8, 8, 'category', 'C2', 2, 1),
(9, 9, 'nav_menu', '', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'admin'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', 'theme_editor_notice'),
(15, 1, 'show_welcome_panel', '1'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '47'),
(18, 1, 'session_tokens', 'a:1:{s:64:\"5fedd681ae83ff27a1a255b39bb78f065f7e17e9193d8ceda279a40ccf8b32dc\";a:4:{s:10:\"expiration\";i:1633214190;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:114:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36\";s:5:\"login\";i:1633041390;}}'),
(19, 1, 'wp_user-settings', 'libraryContent=browse'),
(20, 1, 'wp_user-settings-time', '1632348215'),
(21, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(22, 1, 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:\"add-post_tag\";}'),
(23, 1, 'nav_menu_recently_edited', '9'),
(24, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:9:\"127.0.0.0\";}');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BbPkE4ib6B5LFHSva9zti617UEv34F0', 'admin', 'admin@admin.com', 'http://wordpress.local', '2021-09-16 03:48:34', '', 0, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp581_commentmeta`
--
ALTER TABLE `wp581_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp581_comments`
--
ALTER TABLE `wp581_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `wp581_links`
--
ALTER TABLE `wp581_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp581_options`
--
ALTER TABLE `wp581_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `wp581_postmeta`
--
ALTER TABLE `wp581_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp581_posts`
--
ALTER TABLE `wp581_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp581_termmeta`
--
ALTER TABLE `wp581_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp581_terms`
--
ALTER TABLE `wp581_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp581_term_relationships`
--
ALTER TABLE `wp581_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp581_term_taxonomy`
--
ALTER TABLE `wp581_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp581_usermeta`
--
ALTER TABLE `wp581_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp581_users`
--
ALTER TABLE `wp581_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp581_commentmeta`
--
ALTER TABLE `wp581_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp581_comments`
--
ALTER TABLE `wp581_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp581_links`
--
ALTER TABLE `wp581_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp581_options`
--
ALTER TABLE `wp581_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- AUTO_INCREMENT for table `wp581_postmeta`
--
ALTER TABLE `wp581_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `wp581_posts`
--
ALTER TABLE `wp581_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `wp581_termmeta`
--
ALTER TABLE `wp581_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp581_terms`
--
ALTER TABLE `wp581_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wp581_term_taxonomy`
--
ALTER TABLE `wp581_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wp581_usermeta`
--
ALTER TABLE `wp581_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wp581_users`
--
ALTER TABLE `wp581_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

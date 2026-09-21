<?php require APPROOT . '/Views/admin/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@400;700;800&display=swap');

    /* Front-end Match Styles for Post Detail View */
    .post-content-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 25px;
        color: #000000;
        text-align: left !important;
        font-family: 'Noto Serif Bengali', serif !important;
    }

    .post-featured-img {
        display: block;
        width: 100%;
        max-width: 1280px;
        height: auto;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        margin: 0 auto 30px auto;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .post-body {
        font-size: 18px;
        line-height: 1.75;
        color: #000000;
        text-align: justify;
        text-justify: inter-word;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
    }

    .post-body, .post-body *:not(.fa):not(.fas):not(.far):not(.fab) {
        font-family: 'Noto Serif Bengali', serif !important;
    }

    .post-body p { 
        margin-bottom: 20px; 
        text-align: justify;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .post-body h2 {
        position: relative;
        padding-bottom: 12px;
        margin-top: 45px;
        margin-bottom: 25px;
        color: #1e293b;
        font-size: 1.8rem;
        font-weight: 800;
    }
    .post-body h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background: #e2e8f0;
        border-radius: 2px;
    }
    .post-body h2::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 80px;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
        z-index: 1;
    }

    .post-body h3 {
        position: relative;
        padding-bottom: 10px;
        margin-top: 35px;
        margin-bottom: 20px;
        color: #334155;
        font-size: 1.45rem;
        font-weight: 700;
    }
    .post-body h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 120px;
        height: 2px;
        background: repeating-linear-gradient(to right, var(--primary), var(--primary) 6px, transparent 6px, transparent 12px);
    }

    .post-body h4 {
        position: relative;
        padding-left: 12px;
        margin-top: 30px;
        margin-bottom: 15px;
        color: #475569;
        font-size: 1.2rem;
        font-weight: 700;
        border-left: 3px solid #cbd5e1;
    }

    .post-body blockquote {
        position: relative;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 6px solid #2563eb;
        border-radius: 14px;
        padding: 24px 30px 24px 44px;
        margin: 30px 0;
        font-style: normal;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .post-body blockquote::before {
        content: "\f10d";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 15px;
        top: 22px;
        font-size: 20px;
        color: rgba(37, 99, 235, 0.15);
        transition: color 0.3s ease;
    }

    .post-body blockquote:hover {
        border-left-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.08), 0 5px 15px rgba(0, 0, 0, 0.02);
    }

    .post-body blockquote:hover::before {
        color: rgba(37, 99, 235, 0.35);
    }

    .post-body blockquote p {
        margin-bottom: 12px;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .post-body blockquote p:last-child {
        margin-bottom: 0;
    }

    .post-body ul, 
    .post-body ol {
        margin-bottom: 20px;
        padding-left: 25px !important;
        list-style-position: outside !important;
    }

    .post-body li {
        margin-bottom: 8px;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .post-part-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    /* Sidebar TOC Styles */
    #quickViewTocContainer .post-toc-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        max-height: 350px;
        overflow-y: auto;
        font-family: 'Noto Serif Bengali', serif !important;
        font-size: 14px;
        line-height: 1.5;
    }
    #quickViewTocContainer .toc-list {
        list-style: none !important;
        padding-left: 0 !important;
        margin: 0 !important;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    #quickViewTocContainer .toc-item {
        list-style: none !important;
    }
    #quickViewTocContainer .toc-item a {
        text-decoration: none;
        color: #475569;
        font-weight: 600;
        display: inline-flex;
        align-items: flex-start;
        gap: 6px;
        transition: color 0.2s ease;
    }
    #quickViewTocContainer .toc-item a:hover {
        color: #2563eb;
    }
    #quickViewTocContainer .toc-number {
        color: #64748b;
        font-weight: 700;
    }
    #quickViewTocContainer .toc-h3 {
        padding-left: 15px !important;
    }
    #quickViewTocContainer .toc-h3 a {
        font-size: 13px;
        font-weight: 500;
    }
    #quickViewTocContainer .toc-h4 {
        padding-left: 30px !important;
    }
    #quickViewTocContainer .toc-h4 a {
        font-size: 12px;
        font-weight: 400;
        color: #64748b;
    }

    /* Heading Highlight on scroll click */
    .highlight-heading {
        animation: highlightAnimation 2s ease;
    }

    @keyframes highlightAnimation {
        0%, 100% { background: transparent; }
        30% { background: rgba(37, 99, 235, 0.1); border-radius: 4px; padding: 2px 5px; }
    }

    /* Active post highlight styles */
    .folder-tree-node.post-node.active-post {
        background: #e0f2fe !important;
        border-radius: 6px;
        font-weight: 600;
    }
    .folder-tree-node.post-node.active-post a {
        color: #0369a1 !important;
    }
    .folder-tree-node.post-node.active-post i {
        color: #0284c7 !important;
    }
    tr.active-post {
        background-color: #f0f9ff !important;
    }
    tr.active-post td {
        border-top-color: #bae6fd !important;
        border-bottom-color: #bae6fd !important;
    }

    /* Override main-content padding on this page to expand width and maintain consistent layout */
    .main-content {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        padding-top: 1.5rem !important;
    }
    body.sidebar-collapsed .main-content {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        padding-top: 1.5rem !important;
    }

    /* Category Dropdown Tooltip Styles */
    .cat-drop-wrapper {
        position: relative;
        display: inline-block;
    }
    .cat-drop-menu {
        display: none;
        position: absolute;
        bottom: 110%;
        left: 0;
        z-index: 99;
        min-width: 170px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        padding: 8px;
        margin-bottom: 4px;
    }
    .cat-drop-wrapper:hover .cat-drop-menu {
        display: block;
    }
    .cat-drop-item {
        display: block;
        background: #f8fafc;
        color: #475569;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 11px;
        margin-bottom: 4px;
        white-space: nowrap;
    }
    .cat-drop-item:last-child {
        margin-bottom: 0;
    }

    /* Premium Modern Folder Explorer UI Styles */
    .explorer-body {
        background: #f8fafc;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: #334155;
        padding: 24px 0px 24px 24px;
        min-height: calc(100vh - 80px);
    }

    /* Header & Action buttons */
    .explorer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .explorer-title-section {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .explorer-title-section h1 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #0f172a;
    }

    .explorer-actions {
        display: flex;
        gap: 12px;
    }

    .btn-explorer {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        text-decoration: none;
    }

    .btn-explorer-primary {
        background: #2563eb;
        color: #fff;
    }

    .btn-explorer-primary:hover {
        background: #1d4ed8;
    }

    .btn-explorer-secondary {
        background: #fff;
        color: #475569;
        border-color: #cbd5e1;
    }

    .btn-explorer-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    /* Layout: Sidebar + Main Content */
    .main-content {
        padding-top: 1.5rem !important;
    }
    body.sidebar-collapsed .main-content {
        padding-top: 1.5rem !important;
    }

    .explorer-body {
        padding-top: 0px !important;
    }

    .explorer-layout {
        display: block;
        position: relative;
    }

    .explorer-main {
        margin-left: 356px;
        transition: margin-left 0.3s ease;
    }

    body.sidebar-collapsed .explorer-main {
        margin-left: 356px;
    }

    /* Sidebar Styles */
    .explorer-sidebar {
        position: fixed;
        top: 24px;
        left: calc(280px + 24px);
        width: 332px;
        max-height: calc(100vh - 48px);
        overflow: hidden;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: left 0.3s ease;
    }

    body.sidebar-collapsed .explorer-sidebar {
        left: calc(80px + 24px);
    }

    .sidebar-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
        max-height: 100%;
        min-height: 0;
        flex-shrink: 1;
        transition: max-height 0.2s ease;
    }

    .explorer-sidebar.has-toc > .sidebar-card {
        flex: 1 1 50% !important;
        height: calc(50% - 8px) !important;
        max-height: calc(50% - 8px) !important;
        min-height: 0 !important;
    }

    /* Custom elegant scrollbar for the explorer sidebar cards */
    .sidebar-card::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar-card::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .sidebar-card::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .sidebar-card::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Footnote Tooltip styles */
    .footnote-ref-link {
        position: relative;
        cursor: pointer;
    }
    .footnote-ref-link::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 130%;
        left: 50%;
        transform: translateX(-50%) scale(0.9);
        background: #1e293b;
        color: #ffffff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        z-index: 1000;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        max-width: 320px;
        white-space: normal;
        line-height: 1.4;
        text-align: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }
    .footnote-ref-link:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) scale(1);
    }

    /* Highlight class for active item inside Sidebar Tree */
    .folder-tree-node.active-post {
        background: #e0f2fe !important;
        border-radius: 6px;
        font-weight: 600;
    }
    .folder-tree-node.active-post a {
        color: #0369a1 !important;
    }
    .folder-tree-node.active-post i {
        color: #0284c7 !important;
    }

    .sidebar-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 12px 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .folder-tree-list {
        list-style: none;
        padding-left: 14px;
        margin: 4px 0;
    }

    .folder-tree-list.collapsed {
        display: none !important;
    }

    .explorer-sidebar > .folder-tree-list {
        padding-left: 0;
    }

    .folder-tree-item {
        margin: 4px 0;
    }

    .folder-tree-node {
        display: flex;
        align-items: center;
        padding: 6px 8px;
        border-radius: 8px;
        transition: all 0.15s ease;
        position: relative;
    }

    .folder-tree-node:hover {
        background: #f1f5f9;
    }

    .folder-tree-node.active {
        background: #eff6ff;
        font-weight: 600;
    }

    .folder-tree-node.active a {
        color: #1d4ed8;
    }

    .folder-tree-node a {
        color: #475569;
        text-decoration: none;
        font-size: 13px;
        display: block;
        width: 100%;
    }

    .folder-tree-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        color: #94a3b8;
        cursor: pointer;
        margin-right: 4px;
        font-size: 10px;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }

    .folder-tree-toggle:hover {
        color: #475569;
        background: #f1f5f9;
        border-radius: 4px;
    }

    .folder-tree-spacer {
        width: 18px;
        margin-right: 4px;
        flex-shrink: 0;
    }

    /* Tree Node Action Buttons on Hover */
    .tree-actions {
        display: none;
        margin-left: auto;
        gap: 6px;
        align-items: center;
    }

    .folder-tree-node:hover .tree-actions {
        display: flex;
    }

    .btn-tree-action {
        color: #94a3b8;
        cursor: pointer;
        font-size: 11px;
        transition: color 0.15s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px;
    }

    .btn-tree-action:hover {
        color: #475569;
    }

    .btn-tree-action.delete:hover {
        color: #ef4444;
    }

    .explorer-main {
        min-width: 0; /* Prevents grid layout blowout */
    }

    /* Breadcrumbs Navigation */
    .explorer-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        list-style: none;
        padding: 12px 16px;
        margin: 0 0 24px 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }

    .explorer-breadcrumbs li {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
    }

    .explorer-breadcrumbs li a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .explorer-breadcrumbs li a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .explorer-breadcrumbs li .separator {
        color: #cbd5e1;
    }

    /* Folders Section Grid */
    .explorer-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #475569;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .folder-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        text-decoration: none;
        color: inherit;
    }

    .folder-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .folder-icon {
        font-size: 28px;
        color: #f59e0b;
        flex-shrink: 0;
    }

    .folder-info {
        flex-grow: 1;
        min-width: 0;
    }

    .folder-name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        margin: 0;
        word-break: break-word;
    }

    .folder-card-actions {
        display: flex;
        align-items: center;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
    }

    .folder-card:hover .folder-card-actions {
        opacity: 1;
    }

    .btn-folder-card-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-folder-card-action:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-folder-card-action.delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .folder-actions-trigger {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }

    .folder-actions-trigger:hover {
        color: #475569;
        background: #f1f5f9;
    }

    .folder-menu-container {
        position: absolute;
        right: 12px;
        top: 16px;
    }

    .folder-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 50;
        min-width: 120px;
        padding: 4px;
    }

    .folder-dropdown-menu.show {
        display: block;
    }

    .folder-dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 8px 12px;
        font-size: 13px;
        color: #475569;
        border: none;
        background: none;
        text-align: left;
        cursor: pointer;
        border-radius: 6px;
        text-decoration: none;
    }

    .folder-dropdown-item:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .folder-dropdown-item.delete {
        color: #ef4444;
    }

    .folder-dropdown-item.delete:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Empty state styling */
    .empty-state {
        background: #fff;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 12px;
        color: #cbd5e1;
    }

    /* Table/Files Section */
    .files-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .files-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .files-header-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .bulk-action-bar {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .explorer-select {
        padding: 6px 12px;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #fff;
        color: #334155;
        outline: none;
    }

    .explorer-select:focus {
        border-color: #2563eb;
    }

    /* Modern clean table */
    .explorer-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        text-align: left;
    }

    .explorer-table th,
    .explorer-table td {
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .explorer-table th {
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .explorer-table tbody tr:hover {
        background: #f8fafc;
    }

    .post-title-link {
        font-weight: 600;
        color: #1e293b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .post-title-link:hover {
        color: #2563eb;
    }

    .post-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 9999px;
    }

    .post-badge-published {
        background: #ecfdf5;
        color: #059669;
    }

    .post-badge-draft {
        background: #f1f5f9;
        color: #64748b;
    }

    /* Actions inside row */
    .row-actions-group {
        display: flex;
        gap: 8px;
    }

    .btn-row-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        color: #64748b;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-row-action:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .btn-row-action-delete:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    /* Pagination container */
    .explorer-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        font-size: 13px;
        color: #64748b;
    }

    .pagination-buttons {
        display: flex;
        gap: 4px;
    }

    .pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
    }

    .pagination-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .pagination-btn.active {
        background: #2563eb;
        color: #fff;
        border-color: #2563eb;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Modal Styling */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex !important;
    }

    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalScale 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalScale {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 20px;
        padding: 4px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        color: #475569;
        background: #f1f5f9;
    }

    .modal-body {
        padding: 20px 24px;
    }

    .modal-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .modal-form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    .modal-input {
        padding: 10px 14px;
        font-size: 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
        outline: none;
    }

    .modal-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    /* Mobile Responsive Optimizations for Posts Explorer */
    @media (max-width: 1200px) {
        .main-content {
            margin-left: 0 !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
            width: 100% !important;
        }
        body.sidebar-collapsed .main-content {
            margin-left: 0 !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
            width: 100% !important;
        }
        .explorer-body {
            padding: 8px 0px !important;
        }
        .explorer-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 16px !important;
            margin-bottom: 20px !important;
            padding-top: 0 !important;
        }
        .explorer-title-section h1 {
            font-size: 1.5rem !important;
            justify-content: flex-start !important;
        }
        .explorer-actions {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)) !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .explorer-actions a, .explorer-actions button {
            text-align: center !important;
            justify-content: center !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
            margin: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .explorer-layout {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
        .explorer-sidebar {
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            max-height: none !important;
            overflow-y: visible !important;
            box-sizing: border-box !important;
        }
        .explorer-main {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .folder-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)) !important;
            gap: 12px !important;
        }
        .folder-card {
            padding: 12px !important;
        }
        .files-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }
        .bulk-action-bar {
            width: 100% !important;
            display: flex !important;
            gap: 8px !important;
        }
        .bulk-action-bar select {
            flex: 1 !important;
        }
        .explorer-table th:nth-child(3), 
        .explorer-table td:nth-child(3),
        .explorer-table th:nth-child(4), 
        .explorer-table td:nth-child(4) {
            display: none !important; /* Hide Author and Date on small mobile screens to prevent compression */
        }
        .row-actions-group {
            gap: 4px !important;
        }
        .btn-row-action {
            width: 32px !important;
            height: 32px !important;
        }
        #explorerPostDetailView {
            padding: 8px 0px !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .post-content-title {
            font-size: 1.8rem !important;
        }
        .font-controls {
            margin-top: 10px !important;
        }
        /* Borderless container elements for maximum screen width */
        .admin-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0px !important;
            background: transparent !important;
            margin: 0 !important;
        }
        .explorer-sidebar {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
            margin-bottom: 20px !important;
        }
        .explorer-breadcrumbs {
            border: none !important;
            padding: 8px 0 !important;
            margin-bottom: 12px !important;
            background: transparent !important;
        }
        .files-section {
            border: none !important;
            padding: 10px 0 !important;
            margin: 0 !important;
        }
        .data-table-container, .explorer-table {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .explorer-table td, .explorer-table th {
            padding: 8px 0px !important;
        }
        /* Mobile inline actions logic */
        .mobile-row-actions {
            display: flex !important;
        }
        .desktop-actions-cell, .explorer-table th:last-child {
            display: none !important;
        }
        /* Mobile font size enlargement */
        .folder-tree-node a, .folder-tree-node.post-node a, .post-title-link span {
            font-size: 15px !important;
        }
        .sidebar-title {
            font-size: 15px !important;
        }
        .files-header-title {
            font-size: 18px !important;
        }
    }

    /* Drag-and-drop sortable styles */
    .sortable-ghost {
        opacity: 0.35;
        background: #dbeafe !important;
        border-radius: 8px;
    }
    .sortable-chosen {
        background: #eff6ff !important;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(37,99,235,0.15);
    }
    .folder-drag-handle {
        display: none !important;
    }
    .drag-active .folder-drag-handle {
        display: inline-block !important;
    }
    .folder-drag-handle:hover {
        color: #94a3b8 !important;
    }
    .folder-drag-handle:active {
        cursor: grabbing !important;
    }
    
    /* Toggle post visibility in sidebar tree */
    .hide-posts-in-tree .post-tree-item {
        display: none !important;
    }
    .hide-posts-in-tree .folder-tree-item:not(:has(.folder-tree-list .folder-tree-item)) > .folder-tree-node > .folder-tree-toggle {
        visibility: hidden !important;
        pointer-events: none !important;
    }
</style>

<?php
// PHP Recursive function to render directory tree (folders only, no posts — for performance)
if (!function_exists('renderCategoryTree')) {
    function renderCategoryTree($categories, $allPosts, $parentId = null, $currentCategoryId = null, $ancestorIds = [], $catsWithPosts = []) {
        $branch = [];
        foreach ($categories as $cat) {
            $catParent = $cat['parent_id'] ? (int)$cat['parent_id'] : null;
            $filterParent = $parentId ? (int)$parentId : null;
            if ($catParent === $filterParent) {
                $branch[] = $cat;
            }
        }
        
        if (empty($branch)) return '';
        
        $html = '';
        foreach ($branch as $cat) {
            $isActive = ($currentCategoryId !== null && (int)$cat['id'] === (int)$currentCategoryId) ? 'active' : '';
            
            // Check if this category has child folders
            $hasChildFolders = false;
            foreach ($categories as $child) {
                if ($child['parent_id'] && (int)$child['parent_id'] === (int)$cat['id']) {
                    $hasChildFolders = true;
                    break;
                }
            }
            
            $isExpanded = in_array((int)$cat['id'], $ancestorIds) || ($currentCategoryId !== null && (int)$cat['id'] === (int)$currentCategoryId);
            
            $catPosts = [];
            if ($isExpanded && $currentCategoryId !== null && (int)$cat['id'] === (int)$currentCategoryId && !empty($allPosts)) {
                foreach ($allPosts as $post) {
                    $postCatId = $post['category_id'] ? (int)$post['category_id'] : null;
                    if ($postCatId === (int)$cat['id']) {
                        $catPosts[] = $post;
                    }
                }
            }
            
            $hasPosts = !empty($catsWithPosts) && in_array((int)$cat['id'], $catsWithPosts);
            $hasChildrenInTree = ($hasChildFolders || $hasPosts);
            
            $html .= '<li class="folder-tree-item" data-cat-id="' . (int)$cat['id'] . '">';
            $html .= '<div class="folder-tree-node ' . $isActive . '">';
            $html .= '<span class="folder-drag-handle" title="Drag to reorder" style="cursor: grab; color: #cbd5e1; padding: 0 4px; flex-shrink: 0; font-size: 12px;">&#9776;</span>';
            
            if ($hasChildrenInTree) {
                $chevronClass = $isExpanded ? 'fa-chevron-down' : 'fa-chevron-right';
                $html .= '<span class="folder-tree-toggle" onclick="toggleTreeBranch(event, this)">';
                $html .= '<i class="fas ' . $chevronClass . '"></i>';
                $html .= '</span>';
            } else {
                $html .= '<span class="folder-tree-spacer"></span>';
            }
            
            $html .= '<a href="' . URLROOT . '/admin/posts?category_id=' . $cat['id'] . '" title="' . htmlspecialchars($cat['name']) . '" style="display: flex; align-items: center; gap: 8px; width: 100%; text-decoration: none; color: inherit;">';
            $html .= '<i class="fas fa-folder" style="color: #f59e0b; flex-shrink: 0; margin-right: 0;"></i>';
            $html .= '<span>' . htmlspecialchars($cat['name']) . '</span>';
            $html .= '</a>';
            
            $html .= '</div>';
            
            if ($hasChildrenInTree) {
                $subCollapsed = !$isExpanded;
                $subClassSuffix = $subCollapsed ? ' collapsed' : '';
                $dataLoadedAttr = $isExpanded ? ' data-loaded="true"' : '';
                $html .= '<ul class="folder-tree-list' . $subClassSuffix . '"' . $dataLoadedAttr . ' data-parent-id="' . $cat['id'] . '">';
                if ($hasChildFolders) {
                    $html .= renderCategoryTree($categories, $allPosts, $cat['id'], $currentCategoryId, $ancestorIds, $catsWithPosts);
                }
                foreach ($catPosts as $post) {
                    $html .= '<li class="post-tree-item" style="margin: 2px 0; list-style: none;">';
                    $html .= '<div class="folder-tree-node post-node" data-post-id="' . $post['id'] . '" style="padding: 4px 8px 4px 20px;">';
                    $html .= '<span class="folder-tree-spacer"></span>';
                    $html .= '<a href="#" onclick="openQuickView(event, ' . $post['id'] . ')" style="display: flex; align-items: center; gap: 8px; width: 100%; text-decoration: none; color: #4b5563; font-size: 13px;">';
                    $html .= '<i class="far fa-file-alt" style="color: #64748b; flex-shrink: 0; font-size: 12px;"></i>';
                    $html .= '<span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . htmlspecialchars($post['title']) . '">' . htmlspecialchars($post['title']) . '</span>';
                    if ($post['status'] === 'draft') {
                        $html .= '<span class="post-badge post-badge-draft" style="font-size: 9px; padding: 1px 4px; margin-left: 4px; background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 4px;">Draft</span>';
                    }
                    $html .= '</a>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
            
            $html .= '</li>';
        }
        return $html;
    }
}

// Convert breadcrumbs to ancestor IDs
$ancestorIds = [];
if (!empty($data['breadcrumbs'])) {
    $ancestorIds = array_map(function($b) {
        return (int)$b['id'];
    }, $data['breadcrumbs']);
}
?>

<div class="explorer-body">
    <!-- Explorer Layout: Sidebar + Content -->
    <div class="explorer-layout">
        <!-- Sidebar Tree View -->
        <div class="explorer-sidebar">
            <div class="sidebar-card" id="sidebar-tree-card">
                <h3 class="sidebar-title" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 12px;">
                    <div style="display: flex; gap: 4px; align-items: center; justify-content: flex-start; width: 100%;">
                        <?php if ($data['categoryId'] !== null): ?>
                            <?php 
                                $showMode = $data['showMode'] ?? 'all'; 
                                $nextMode = ($showMode === 'primary') ? 'all' : 'primary';
                                $buttonText = ($showMode === 'primary') ? 'Primary' : 'All';
                                $buttonIcon = ($showMode === 'primary') ? 'fa-filter' : 'fa-list-ul';
                            ?>
                            <a href="?category_id=<?= $data['categoryId'] ?>&show_mode=<?= $nextMode ?>" class="btn-explorer btn-explorer-secondary btn-show-mode-toggle" style="padding: 2px 6px; font-size: 11px; height: auto; font-weight: 500; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px; width: 72px; box-sizing: border-box;" title="Switch post filter mode" data-next-mode="<?= $nextMode ?>">
                                <i class="fas <?= $buttonIcon ?>"></i> <?= $buttonText ?>
                            </a>
                        <?php endif; ?>
                        <button type="button" id="btn-toggle-posts" class="btn-explorer btn-explorer-secondary" style="padding: 2px 8px; font-size: 11px; height: auto; font-weight: 500; border-radius: 6px;" title="Show/Hide Posts">
                            <i class="fas fa-eye"></i> Posts
                        </button>
                        <button type="button" id="btn-adjust-folders" class="btn-explorer btn-explorer-secondary" style="padding: 2px 8px; font-size: 11px; height: auto; font-weight: 500; border-radius: 6px;">
                            <i class="fas fa-arrows-alt"></i> Adjust
                        </button>
                    </div>
                    <span style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; text-transform: uppercase; color: #475569; letter-spacing: 0.05em;">
                        <i class="fas fa-sitemap"></i> Folder Hierarchy
                    </span>
                </h3>
                
                <ul class="folder-tree-list">
                    <li class="folder-tree-item">
                        <div class="folder-tree-node <?= $data['categoryId'] === null ? 'active' : '' ?>">
                            <span class="folder-tree-spacer"></span>
                            <a href="<?= URLROOT ?>/admin/posts" style="display: flex; align-items: center; gap: 8px; width: 100%; text-decoration: none; color: inherit;">
                                <i class="fas fa-home" style="color: #64748b; flex-shrink: 0; margin-right: 0;"></i>
                                <span>Root Folder</span>
                            </a>
                        </div>
                        <ul class="folder-tree-list" id="sortable-root-tree"
                            data-parent-id="">  
                            <?= renderCategoryTree($data['allCategories'], $data['allPosts'] ?? [], null, $data['categoryId'], $ancestorIds, $data['catsWithPosts'] ?? []) ?>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Quick View Table of Contents Container -->
            <div id="quickViewTocContainer" class="sidebar-card" style="display: none;">
                <h4 class="sidebar-title" style="margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-list-ol" style="color: #475569;"></i> সূচিপত্র (TOC)
                </h4>
                <div id="quickViewTocContent" class="post-toc-box">
                    <!-- TOC links will load here dynamically -->
                </div>
            </div>
        </div>

        <!-- Main Explorer view -->
        <div class="explorer-main">
            <!-- Header -->
            <div class="explorer-header">
                <div class="explorer-title-section">
                    <h1 style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <span><?= $data['currentCategory'] ? htmlspecialchars($data['currentCategory']['name']) : 'Posts Manager' ?></span>
                        <?php if ($data['categoryId'] !== null): ?>
                            <button class="btn-explorer btn-explorer-secondary" style="padding: 4px 10px; font-size: 12px;" onclick="openRenameModal(event, <?= $data['categoryId'] ?>, '<?= htmlspecialchars($data['currentCategory']['name'], ENT_QUOTES) ?>')">
                                <i class="fas fa-edit"></i> Rename
                            </button>
                            <button type="button" class="btn-explorer btn-explorer-secondary" style="padding: 4px 10px; font-size: 12px;" onclick="openMoveModal(event, <?= $data['categoryId'] ?>, '<?= htmlspecialchars($data['currentCategory']['name'], ENT_QUOTES) ?>')">
                                <i class="fas fa-arrows-alt"></i> Move
                            </button>
                            <a href="<?= URLROOT ?>/admin/delete_folder/<?= $data['categoryId'] ?>?parent_id=<?= $data['currentCategory']['parent_id'] ?? '' ?>" class="btn-explorer btn-explorer-secondary" style="padding: 4px 10px; font-size: 12px; border-color: #fca5a5; color: #dc2626; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this folder?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                            <button type="button" class="btn-explorer btn-explorer-secondary" style="padding: 4px 10px; font-size: 12px;" onclick="openSelectPostsModal(<?= $data['categoryId'] ?>)">
                                <i class="fas fa-tasks"></i> Select Posts
                            </button>
                        <?php endif; ?>
                    </h1>
                </div>
                <div class="explorer-actions" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <!-- Compact Search Bar -->
                    <div style="position: relative; width: 220px; margin-bottom: 0;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none;"></i>
                        <input type="text" id="postSearchInput" placeholder="Search posts..." oninput="filterPostsTable(this.value)"
                            style="width: 100%; padding: 6px 12px 6px 32px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #0f172a; background: #fff; outline: none; box-sizing: border-box; transition: all 0.2s; height: 34px;"
                            onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.12)'"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                    </div>

                    <button class="btn-explorer btn-explorer-secondary" style="height: 34px; padding: 6px 12px; font-size: 13px;" onclick="openImportDocModal()">
                        <i class="fas fa-file-import"></i> Import DOC
                    </button>
                    <button class="btn-explorer btn-explorer-secondary" style="height: 34px; padding: 6px 12px; font-size: 13px;" onclick="openNewFolderModal()">
                        <i class="fas fa-folder-plus"></i> New Folder
                    </button>
                    <a href="<?= URLROOT ?>/admin/add_post?category_id=<?= $data['categoryId'] ?>" class="btn-explorer btn-explorer-primary" style="height: 34px; padding: 6px 12px; font-size: 13px; display: inline-flex; align-items: center;">
                        <i class="fas fa-plus"></i> Add Post
                    </a>
                </div>
            </div>

            <div id="explorerListView">
                <!-- Breadcrumbs -->
                <ul class="explorer-breadcrumbs">
                <li>
                    <a href="<?= URLROOT ?>/admin/posts">
                        <i class="fas fa-home"></i> Root
                    </a>
                </li>
                <?php foreach ($data['breadcrumbs'] as $index => $crumb): ?>
                    <li>
                        <span class="separator"><i class="fas fa-chevron-right" style="font-size: 10px;"></i></span>
                        <a href="<?= URLROOT ?>/admin/posts?category_id=<?= $crumb['id'] ?>">
                            <i class="fas fa-folder-open" style="color: #f59e0b;"></i> <?= htmlspecialchars($crumb['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>


            <?php if (!empty($data['subFolders'])): ?>
                <!-- Subfolders Grid Section -->
                <div style="margin-bottom: 24px;">
                    <h2 class="explorer-section-title">
                        <i class="fas fa-folder" style="color: #64748b;"></i> Subfolders
                    </h2>
                    <div class="folder-grid">
                        <?php foreach ($data['subFolders'] as $folder): ?>
                            <div class="folder-card" data-href="<?= URLROOT ?>/admin/posts?category_id=<?= $folder['id'] ?>">
                                <i class="fas fa-folder folder-icon"></i>
                                <div class="folder-info">
                                    <h3 class="folder-name" title="<?= htmlspecialchars($folder['name']) ?>"><?= htmlspecialchars($folder['name']) ?></h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Posts/Files Section -->
            <div class="files-section">
                <div class="files-header">
                    <h2 class="files-header-title">Articles inside this Folder</h2>
                    <div class="bulk-action-bar">
                        <select class="explorer-select" id="bulkActionSelect">
                            <option value="-1">Bulk Actions</option>
                            <option value="delete">Move to Trash</option>
                        </select>
                        <button class="btn-explorer btn-explorer-secondary" onclick="applyBulkAction()" style="padding: 6px 12px;">Apply</button>
                    </div>
                </div>

                <?php if (empty($data['posts'])): ?>
                    <div class="empty-state" style="border: none; border-radius: 0;">
                        <i class="fas fa-file-alt empty-state-icon"></i>
                        <p style="margin: 0;">No articles in this folder. Click "Add Post" to create one.</p>
                    </div>
                <?php else: ?>
                    <table class="explorer-table">
                        <thead>
                            <tr>
                                <th style="width: 40px; text-align: center;"><input type="checkbox" onclick="toggleSelectAll(this)"></th>
                                <th>Title</th>
                                <th style="width: 100px; text-align: center;">Category</th>
                                <th>Date</th>
                                <th style="width: 120px; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['posts'] as $post): 
                                $isDraft = (isset($post['status']) && strtolower($post['status']) === 'draft');
                            ?>
                                <tr data-post-id="<?= $post['id'] ?>">
                                    <td style="text-align: center;">
                                        <input type="checkbox" value="<?= $post['id'] ?>" class="post-checkbox">
                                    </td>
                                    <td>
                                        <a href="#" onclick="openQuickView(event, <?= $post['id'] ?>)" class="post-title-link">
                                            <i class="far fa-file-alt" style="color: #64748b;"></i>
                                            <span><?= htmlspecialchars($post['title']) ?></span>
                                        </a>
                                        <?php if ($isDraft): ?>
                                            <span class="post-badge post-badge-draft">Draft</span>
                                        <?php else: ?>
                                            <span class="post-badge post-badge-published">Published</span>
                                        <?php endif; ?>
                                        
                                        <!-- Mobile Inline Actions under Title -->
                                        <div class="mobile-row-actions" style="display: none; margin-top: 8px; gap: 12px; align-items: center;">
                                             <a href="<?= URLROOT ?>/<?= htmlspecialchars($post['slug']) ?>" target="_blank" style="color: #2563eb; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                                 <i class="far fa-eye"></i> View
                                             </a>
                                             <a href="<?= URLROOT ?>/admin/edit_post/<?= $post['id'] ?>?page=<?= $data['currentPageNum'] ?? 1 ?>&category_id=<?= $data['categoryId'] ?? '' ?>" style="color: #059669; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                                 <i class="far fa-edit"></i> Edit
                                             </a>
                                             <a href="<?= URLROOT ?>/admin/delete_post/<?= $post['id'] ?>" style="color: #dc2626; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 4px;" onclick="return confirm('Are you sure you want to delete this article?')">
                                                 <i class="far fa-trash-alt"></i> Delete
                                             </a>
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle; position: relative;">
                                        <?php 
                                        $otherCats = [];
                                        if (!empty($post['secondary_categories'])) {
                                            $subCats = explode(', ', $post['secondary_categories']);
                                            foreach ($subCats as $subCat) {
                                                if ($subCat !== $post['main_category']) {
                                                    $otherCats[] = $subCat;
                                                }
                                            }
                                        }
                                        $hasCategory = !empty($post['main_category']) || !empty($otherCats);
                                        ?>
                                        
                                        <?php if ($hasCategory): ?>
                                            <div class="cat-drop-wrapper">
                                                <div class="cat-trigger-icon" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; cursor: pointer; transition: all 0.2s; border: 1px solid #dbeafe;" onmouseover="this.style.background='#2563eb'; this.style.color='#ffffff';" onmouseout="this.style.background='#eff6ff'; this.style.color='#2563eb';">
                                                    <i class="fas fa-tags" style="font-size: 14px;"></i>
                                                </div>
                                                <div class="cat-drop-menu" style="min-width: 190px; text-align: left; left: 50%; transform: translateX(-50%);">
                                                    <?php if (!empty($post['main_category'])): ?>
                                                        <div style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px; margin-bottom: 8px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px; font-size: 12px; white-space: nowrap;">
                                                            <i class="fas fa-folder" style="color: #ea580c; font-size: 11px;"></i> 
                                                            <span><?= htmlspecialchars($post['main_category']) ?></span>
                                                            <span style="font-size: 9px; font-weight: 800; background: #fff7ed; color: #c2410c; padding: 1px 4px; border-radius: 4px; border: 1px solid #ffedd5; margin-left: auto;">MAIN</span>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($otherCats)): ?>
                                                        <?php foreach ($otherCats as $subCat): ?>
                                                            <div class="cat-drop-item" style="font-size: 11px; margin-bottom: 4px; padding: 4px 8px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; white-space: nowrap;">
                                                                <i class="far fa-folder" style="color: #94a3b8; margin-right: 4px;"></i>
                                                                <?= htmlspecialchars($subCat) ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span style="color: #cbd5e1; font-style: italic;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color: #64748b; font-size: 13px;">
                                        <?= date('Y/m/d', strtotime($post['created_at'])) ?>
                                    </td>
                                    <td class="desktop-actions-cell">
                                        <div class="row-actions-group" style="justify-content: flex-end;">
                                             <a href="<?= URLROOT ?>/<?= htmlspecialchars($post['slug']) ?>" target="_blank" class="btn-row-action" title="View on Live Site">
                                                 <i class="far fa-eye"></i>
                                             </a>
                                            <a href="<?= URLROOT ?>/admin/edit_post/<?= $post['id'] ?>?page=<?= $data['currentPageNum'] ?? 1 ?>&category_id=<?= $data['categoryId'] ?? '' ?>" class="btn-row-action" title="Edit Article">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="<?= URLROOT ?>/admin/delete_post/<?= $post['id'] ?>" class="btn-row-action btn-row-action-delete" title="Move to Trash" onclick="return confirm('Are you sure you want to delete this article?')">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if (isset($data['totalPages']) && $data['totalPages'] > 1): 
                        $modeParam = isset($data['showMode']) ? '&show_mode=' . $data['showMode'] : '';
                    ?>
                        <div class="explorer-pagination">
                            <div>
                                Showing Page <?= $data['currentPageNum'] ?> of <?= $data['totalPages'] ?> (<?= $data['totalCount'] ?> items total)
                            </div>
                            <div class="pagination-buttons">
                                <a href="?category_id=<?= $data['categoryId'] ?><?= $modeParam ?>&page=1" class="pagination-btn <?= $data['currentPageNum'] <= 1 ? 'disabled' : '' ?>">&laquo;</a>
                                <a href="?category_id=<?= $data['categoryId'] ?><?= $modeParam ?>&page=<?= max(1, $data['currentPageNum'] - 1) ?>" class="pagination-btn <?= $data['currentPageNum'] <= 1 ? 'disabled' : '' ?>">&lsaquo;</a>
                                
                                <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                    <a href="?category_id=<?= $data['categoryId'] ?><?= $modeParam ?>&page=<?= $i ?>" class="pagination-btn <?= $data['currentPageNum'] == $i ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                                
                                <a href="?category_id=<?= $data['categoryId'] ?><?= $modeParam ?>&page=<?= min($data['totalPages'], $data['currentPageNum'] + 1) ?>" class="pagination-btn <?= $data['currentPageNum'] >= $data['totalPages'] ? 'disabled' : '' ?>">&rsaquo;</a>
                                <a href="?category_id=<?= $data['categoryId'] ?><?= $modeParam ?>&page=<?= $data['totalPages'] ?>" class="pagination-btn <?= $data['currentPageNum'] >= $data['totalPages'] ? 'disabled' : '' ?>">&raquo;</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

            <!-- Main Content Area Post Detail View -->
            <div id="explorerPostDetailView" style="display: none; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); animation: modalScale 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <button type="button" onclick="closePostDetailView()" class="btn-explorer btn-explorer-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 500; font-size: 13px; text-decoration: none; padding: 8px 16px;">
                            <i class="fas fa-arrow-left"></i> Back to Folder
                        </button>
                        
                        <!-- Share Options Action Group -->
                        <div id="detailShareGroup" style="display: none; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 4px 8px;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; margin-right: 4px;">Share:</span>
                            <button type="button" id="btnCopyLink" onclick="copyPostPublicLink()" title="Copy Public Link" class="btn-explorer btn-explorer-secondary" style="padding: 4px 8px; font-size: 12px; height: auto; gap: 4px;">
                                <i class="fas fa-link"></i> <span id="copyLinkText">Copy Link</span>
                            </button>
                            <a id="shareFB" href="#" target="_blank" title="Share on Facebook" class="btn-explorer" style="padding: 4px 8px; font-size: 12px; background: #1877f2; color: white; border: none; height: auto;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a id="shareWA" href="#" target="_blank" title="Share on WhatsApp" class="btn-explorer" style="padding: 4px 8px; font-size: 12px; background: #25d366; color: white; border: none; height: auto;">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a id="shareTwitter" href="#" target="_blank" title="Share on Twitter" class="btn-explorer" style="padding: 4px 8px; font-size: 12px; background: #1da1f2; color: white; border: none; height: auto;">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                        <!-- Font Controls -->
                        <div class="font-controls" style="display: flex; gap: 6px; align-items: center;">
                            <span style="font-size: 12px; font-weight: 500; color: #64748b; margin-right: 4px;">Font:</span>
                            <button type="button" onclick="changeFontSize(-1)" title="Decrease font size" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 8px; cursor: pointer; color: #334155; font-size: 12px; display: flex; align-items: center; justify-content: center; height: 26px; width: 30px;"><i class="fas fa-minus"></i></button>
                            <span id="fontSizeDisplay" style="font-size: 13px; font-weight: 600; color: #334155; min-width: 38px; text-align: center;">18px</span>
                            <button type="button" onclick="changeFontSize(1)" title="Increase font size" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 8px; cursor: pointer; color: #334155; font-size: 12px; display: flex; align-items: center; justify-content: center; height: 26px; width: 30px;"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                
                <h1 id="detailViewTitle" class="post-content-title">Loading...</h1>
                
                <div id="detailViewMetadata" style="font-size: 13px; color: #64748b; margin-bottom: 24px; display: flex; gap: 16px; align-items: center;">
                    <span><i class="far fa-calendar"></i> <span id="detailViewDate"></span></span>
                    <span id="detailViewStatus" class=""></span>
                </div>
                
                <div id="detailViewImageContainer" style="display: none; margin-bottom: 24px; text-align: center; background: #f8fafc; border-radius: 8px; padding: 12px;">
                    <img id="detailViewImage" class="post-featured-img" src="" alt="Post Image" onerror="this.parentNode.style.display='none'">
                </div>
                
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 24px;">
                
                <div id="detailViewContent" class="post-body">
                    <!-- Content will load dynamically -->
                </div>
                <!-- Hidden Audio Player with no-referrer policy to allow Google TTS on localhost -->
                <audio id="ttsAudioPlayer" referrerpolicy="no-referrer" style="display: none;"></audio>
                <!-- Floating fixed button for Quick View scrolling TTS -->
                <button id="quickViewFloatingAudioBtn" onmousedown="event.preventDefault();" onclick="toggleAudioReader()" title="আর্টিকেল শুনুন" style="position: fixed; bottom: 30px; right: 30px; width: 48px; height: 48px; border-radius: 50%; background: #2563eb; color: #ffffff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 4px 15px rgba(37,99,235,0.4); z-index: 9999; transition: all 0.2s ease-in-out;" onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='none';">
                    <i class="fas fa-headphones" id="quickViewFloatingAudioIcon"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Import DOC -->
<div class="modal-overlay" id="importDocModal">
    <div class="modal-content">
        <form action="<?= URLROOT ?>/admin/import_doc" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="category_id" value="<?= $data['categoryId'] ?>">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-file-word" style="color: #2b6cb0;"></i> Import Post from DOC File</h3>
                <button type="button" class="modal-close" onclick="closeImportDocModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-form-group mb-3">
                    <label>Choose Word (.doc / .docx) file</label>
                    <input type="file" name="doc_file" class="modal-input" accept=".doc,.docx" required>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; font-size: 12px; color: #475569; line-height: 1.5;">
                    <strong>Instructions:</strong><br>
                    - The file must be a valid Microsoft Word (.doc / .docx) document.<br>
                    - The document title will automatically become the Post Title.<br>
                    - The text and layout inside the document will be converted into the post content.<br>
                    - The imported post will be saved inside the current folder as a **Draft**.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-explorer btn-explorer-secondary" onclick="closeImportDocModal()">Cancel</button>
                <button type="submit" class="btn-explorer btn-explorer-primary" style="background: #2b6cb0; border-color: #2b6cb0;">Import</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Create Folder -->
<div class="modal-overlay" id="newFolderModal">
    <div class="modal-content">
        <form action="<?= URLROOT ?>/admin/add_folder" method="POST">
            <input type="hidden" name="parent_id" value="<?= $data['categoryId'] ?>">
            <div class="modal-header">
                <h3 class="modal-title">Create New Folder</h3>
                <button type="button" class="modal-close" onclick="closeNewFolderModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-form-group">
                    <label for="new_folder_name">Folder Name (Category Name)</label>
                    <input type="text" id="new_folder_name" name="name" class="modal-input" placeholder="e.g. Fiqh, Science, History..." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-explorer btn-explorer-secondary" onclick="closeNewFolderModal()">Cancel</button>
                <button type="submit" class="btn-explorer btn-explorer-primary">Create Folder</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Rename Folder -->
<div class="modal-overlay" id="renameFolderModal">
    <div class="modal-content">
        <form action="<?= URLROOT ?>/admin/rename_folder" method="POST">
            <input type="hidden" name="parent_id" value="<?= $data['currentCategory']['parent_id'] ?? '' ?>" id="rename_parent_id">
            <input type="hidden" name="id" id="rename_folder_id">
            <div class="modal-header">
                <h3 class="modal-title">Rename Folder</h3>
                <button type="button" class="modal-close" onclick="closeRenameModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-form-group">
                    <label for="rename_folder_name">Folder Name</label>
                    <input type="text" id="rename_folder_name" name="name" class="modal-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-explorer btn-explorer-secondary" onclick="closeRenameModal()">Cancel</button>
                <button type="submit" class="btn-explorer btn-explorer-primary">Rename</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Move Folder -->
<?php
if (!function_exists('renderCategoryDropdownOptions')) {
    function renderCategoryDropdownOptions($categories, $parentId = null, $indent = '', $excludeId = null, $selectedId = null) {
        $forbiddenIds = [];
        if ($excludeId !== null) {
            $forbiddenIds[] = (int)$excludeId;
            $toCheck = [(int)$excludeId];
            while (!empty($toCheck)) {
                $next = array_pop($toCheck);
                foreach ($categories as $cat) {
                    if ($cat['parent_id'] && (int)$cat['parent_id'] === $next) {
                        $forbiddenIds[] = (int)$cat['id'];
                        $toCheck[] = (int)$cat['id'];
                    }
                }
            }
        }

        $html = '';
        foreach ($categories as $cat) {
            $catParent = $cat['parent_id'] ? (int)$cat['parent_id'] : null;
            $filterParent = $parentId ? (int)$parentId : null;
            if ($catParent === $filterParent) {
                if (in_array((int)$cat['id'], $forbiddenIds)) {
                    continue;
                }
                $isSelected = ($selectedId !== null && (int)$cat['id'] === (int)$selectedId) ? 'selected' : '';
                $html .= '<option value="' . (int)$cat['id'] . '" ' . $isSelected . '>' . $indent . htmlspecialchars($cat['name']) . '</option>';
                $html .= renderCategoryDropdownOptions($categories, $cat['id'], $indent . '— ', $excludeId, $selectedId);
            }
        }
        return $html;
    }
}
?>
<div class="modal-overlay" id="moveFolderModal">
    <div class="modal-content">
        <form action="<?= URLROOT ?>/admin/move_folder" method="POST">
            <input type="hidden" name="id" id="move_folder_id" value="<?= $data['categoryId'] ?? '' ?>">
            <div class="modal-header">
                <h3 class="modal-title">Move Folder</h3>
                <button type="button" class="modal-close" onclick="closeMoveModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-form-group">
                    <label for="move_folder_name_display">Folder to Move</label>
                    <input type="text" id="move_folder_name_display" class="modal-input" readonly style="background: #f1f5f9; cursor: not-allowed;">
                </div>
                <div class="modal-form-group" style="margin-top: 15px;">
                    <label for="new_parent_id">Destination Parent Folder</label>
                    <select id="new_parent_id" name="new_parent_id" class="modal-input" style="height: auto; padding: 8px 12px;">
                        <option value="">Root Folder (Make Main Folder)</option>
                        <?php if ($data['categoryId'] !== null): ?>
                            <?= renderCategoryDropdownOptions($data['allCategories'], null, '', $data['categoryId'], $data['currentCategory']['parent_id']) ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-explorer btn-explorer-secondary" onclick="closeMoveModal()">Cancel</button>
                <button type="submit" class="btn-explorer btn-explorer-primary">Move Folder</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Select Posts to Add to Folder -->
<div class="modal-overlay" id="selectPostsModal">
    <div class="modal-content" style="max-width: 600px; width: 90%;">
        <form action="<?= URLROOT ?>/admin/add_posts_to_folder" method="POST">
            <input type="hidden" name="folder_id" id="select_posts_folder_id">
            <div class="modal-header">
                <h3 class="modal-title">Select Posts to Add to Folder</h3>
                <button type="button" class="modal-close" onclick="closeSelectPostsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-form-group" style="margin-bottom: 15px;">
                    <label for="modalPostSearch">Search Posts</label>
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none;"></i>
                        <input type="text" id="modalPostSearch" placeholder="Type to search..." class="modal-input" oninput="filterModalPosts()" style="padding-left: 36px;">
                    </div>
                </div>
                
                <div class="modal-form-group">
                    <label>Available Articles</label>
                    <div id="modalPostsList" style="max-height: 300px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; background: #fff; display: flex; flex-direction: column; gap: 8px;">
                        <div style="text-align: center; color: #64748b; padding: 20px;">Loading posts...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-explorer btn-explorer-secondary" onclick="closeSelectPostsModal()">Cancel</button>
                <button type="submit" class="btn-explorer btn-explorer-primary">Add Selected Posts</button>
            </div>
        </form>
    </div>
</div>

<script>
    let availablePosts = [];
    
    function openSelectPostsModal(folderId) {
        document.getElementById('select_posts_folder_id').value = folderId;
        document.getElementById('selectPostsModal').classList.add('show');
        document.getElementById('modalPostSearch').value = '';
        
        const listContainer = document.getElementById('modalPostsList');
        listContainer.innerHTML = '<div style="text-align: center; color: #64748b; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Loading posts...</div>';
        
        fetch('<?= URLROOT ?>/admin/get_available_posts_ajax?category_id=' + folderId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    availablePosts = data.posts;
                    renderModalPosts();
                } else {
                    listContainer.innerHTML = '<div style="text-align: center; color: #ef4444; padding: 20px;">Failed to load posts</div>';
                }
            })
            .catch(err => {
                console.error(err);
                listContainer.innerHTML = '<div style="text-align: center; color: #ef4444; padding: 20px;">Error loading posts</div>';
            });
    }
    
    function closeSelectPostsModal() {
        document.getElementById('selectPostsModal').classList.remove('show');
    }
    
    function renderModalPosts(filterText = '') {
        const listContainer = document.getElementById('modalPostsList');
        listContainer.innerHTML = '';
        
        const q = filterText.trim().toLowerCase();
        const filtered = availablePosts.filter(post => post.title.toLowerCase().includes(q));
        
        if (filtered.length === 0) {
            listContainer.innerHTML = '<div style="text-align: center; color: #64748b; padding: 20px;">No posts found</div>';
            return;
        }
        
        const currentFolderId = document.getElementById('select_posts_folder_id').value;
        
        filtered.forEach(post => {
            const label = document.createElement('label');
            label.className = 'modal-post-item';
            label.style.display = 'flex';
            label.style.alignItems = 'center';
            label.style.gap = '10px';
            label.style.padding = '8px';
            label.style.border = '1px solid #f1f5f9';
            label.style.borderRadius = '6px';
            label.style.cursor = 'pointer';
            label.style.transition = 'background 0.2s';
            label.onmouseover = () => label.style.background = '#f8fafc';
            label.onmouseout = () => label.style.background = 'transparent';
            
            const isChecked = (post.category_id == currentFolderId) ? 'checked' : '';
            const categoryBadge = post.category_name 
                ? `<span style="font-size: 11px; background: #e2e8f0; color: #475569; padding: 2px 6px; border-radius: 4px; margin-left: auto;">${post.category_name}</span>`
                : `<span style="font-size: 11px; background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; margin-left: auto;">No Folder</span>`;
                
            label.innerHTML = `
                <input type="checkbox" name="post_ids[]" value="${post.id}" ${isChecked} style="width: 16px; height: 16px; cursor: pointer;">
                <span style="font-size: 14px; font-weight: 500; color: #334155;">${post.title}</span>
                ${categoryBadge}
            `;
            listContainer.appendChild(label);
        });
    }
    
    function filterModalPosts() {
        const query = document.getElementById('modalPostSearch').value;
        renderModalPosts(query);
    }

    // Navigation & Dropdown logics
    function navigateToFolder(e, url) {
        if (e.target.closest('.folder-menu-container') || e.target.closest('button') || e.target.closest('.folder-tree-toggle') || e.target.closest('.tree-actions')) {
            return;
        }
        window.location.href = url;
    }

    // Live Search Filter
    function filterPostsTable(query) {
        const q = query.trim().toLowerCase();
        const rows = document.querySelectorAll('.explorer-table tbody tr');
        let visibleCount = 0;
        rows.forEach(row => {
            const titleEl = row.querySelector('.post-title-link span');
            const title = titleEl ? titleEl.textContent.toLowerCase() : '';
            if (!q || title.includes(q)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        // Show/hide empty state hint
        let noResults = document.getElementById('search-no-results');
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'search-no-results';
            noResults.style.cssText = 'padding: 20px; text-align: center; color: #94a3b8; font-size: 14px; display: none;';
            noResults.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px;"></i> No posts match your search.';
            const tbody = document.querySelector('.explorer-table tbody');
            if (tbody) tbody.parentElement.after(noResults);
        }
        noResults.style.display = (q && visibleCount === 0) ? 'block' : 'none';
    }

    function toggleFolderMenu(e, menuId) {
        e.stopPropagation();
        e.preventDefault();
        
        document.querySelectorAll('.folder-dropdown-menu').forEach(menu => {
            if (menu.id !== menuId) {
                menu.classList.remove('show');
            }
        });
        
        const menu = document.getElementById(menuId);
        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.folder-menu-container')) {
            document.querySelectorAll('.folder-dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    function confirmDeleteFolder(e) {
        e.stopPropagation();
        return confirm("Are you sure you want to delete this folder? This will move its subfolders to the parent level!");
    }

    // Toggle tree branch collapse/expand
    function toggleTreeBranch(e, element) {
        e.stopPropagation();
        e.preventDefault();
        
        const nodeDiv = element.closest('.folder-tree-node');
        if (!nodeDiv) return;
        
        const subList = nodeDiv.nextElementSibling;
        const icon = element.querySelector('i');
        
        if (subList && subList.classList.contains('folder-tree-list')) {
            const currentDisplay = window.getComputedStyle(subList).display;
            if (currentDisplay === 'none') {
                subList.style.display = 'block';
                if (icon) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            } else {
                subList.style.display = 'none';
                if (icon) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            }
        }
    }

    // Modals Control
    function openNewFolderModal() {
        document.getElementById('newFolderModal').classList.add('show');
        document.getElementById('new_folder_name').focus();
    }

    function closeNewFolderModal() {
        document.getElementById('newFolderModal').classList.remove('show');
    }

    function openImportDocModal() {
        document.getElementById('importDocModal').classList.add('show');
    }

    function closeImportDocModal() {
        document.getElementById('importDocModal').classList.remove('show');
    }

    // Open Rename Modal
    function openRenameModal(e, folderId, folderName) {
        e.stopPropagation();
        e.preventDefault();
        
        document.getElementById('rename_folder_id').value = folderId;
        document.getElementById('rename_folder_name').value = folderName;
        
        document.getElementById('renameFolderModal').classList.add('show');
        document.getElementById('rename_folder_name').focus();
        
        document.querySelectorAll('.folder-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }

    function closeRenameModal() {
        document.getElementById('renameFolderModal').classList.remove('show');
    }

    // Open Move Modal
    function openMoveModal(e, folderId, folderName) {
        e.stopPropagation();
        e.preventDefault();
        
        document.getElementById('move_folder_id').value = folderId;
        document.getElementById('move_folder_name_display').value = folderName;
        
        document.getElementById('moveFolderModal').classList.add('show');
        
        document.querySelectorAll('.folder-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }

    function closeMoveModal() {
        document.getElementById('moveFolderModal').classList.remove('show');
    }

    // Checkboxes & Bulk actions logic
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.post-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = master.checked;
        });
    }

    function applyBulkAction() {
        const action = document.getElementById('bulkActionSelect').value;
        if (action === 'delete') {
            const selectedCheckbox = document.querySelectorAll('.post-checkbox:checked');
            if (selectedCheckbox.length === 0) {
                alert('No posts selected.');
                return;
            }
            if (confirm(`Are you sure you want to move ${selectedCheckbox.length} selected post(s) to trash?`)) {
                const ids = Array.from(selectedCheckbox).map(cb => cb.value);
                window.location.href = '<?= URLROOT ?>/admin/delete_post/' + ids.join(',');
            }
        }
    }

    function toggleTreeBranch(e, element) {
        e.stopPropagation();
        e.preventDefault();
        
        const node = element.closest('.folder-tree-item');
        if (!node) return;
        
        const subList = node.querySelector('.folder-tree-list');
        const icon = element.querySelector('i');
        const catId = node.dataset.catId;
        
        if (subList) {
            subList.classList.toggle('collapsed');
            const isCollapsed = subList.classList.contains('collapsed');
            
            if (icon) {
                if (isCollapsed) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            }
            
            // Lazy load posts if this branch is expanded and hasn't been loaded yet
            if (!isCollapsed && subList.getAttribute('data-loaded') !== 'true') {
                subList.setAttribute('data-loaded', 'true');
                
                const loadingItem = document.createElement('li');
                loadingItem.className = 'tree-loading-item';
                loadingItem.style.paddingLeft = '20px';
                loadingItem.style.color = '#94a3b8';
                loadingItem.style.fontSize = '12px';
                loadingItem.style.listStyle = 'none';
                loadingItem.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                subList.appendChild(loadingItem);
                
                fetch('<?= URLROOT ?>/admin/get_folder_posts_ajax/' + catId)
                    .then(res => res.json())
                    .then(data => {
                        loadingItem.remove();
                        if (data.success && data.posts) {
                            data.posts.forEach(post => {
                                if (subList.querySelector(`[data-post-id="${post.id}"]`)) return;
                                
                                const li = document.createElement('li');
                                li.className = 'post-tree-item';
                                li.style.margin = '2px 0';
                                li.style.listStyle = 'none';
                                
                                const nodeDiv = document.createElement('div');
                                nodeDiv.className = 'folder-tree-node post-node';
                                nodeDiv.setAttribute('data-post-id', post.id);
                                nodeDiv.style.padding = '4px 8px 4px 20px';
                                
                                const spacer = document.createElement('span');
                                spacer.className = 'folder-tree-spacer';
                                nodeDiv.appendChild(spacer);
                                
                                const link = document.createElement('a');
                                link.href = '#';
                                link.style.display = 'flex';
                                link.style.alignItems = 'center';
                                link.style.gap = '8px';
                                link.style.width = '100%';
                                link.style.textDecoration = 'none';
                                link.style.color = '#4b5563';
                                link.style.fontSize = '13px';
                                link.onclick = function(clickEvent) {
                                    openQuickView(clickEvent, post.id);
                                };
                                
                                const fileIcon = document.createElement('i');
                                fileIcon.className = 'far fa-file-alt';
                                fileIcon.style.color = '#64748b';
                                fileIcon.style.flexShrink = '0';
                                fileIcon.style.fontSize = '12px';
                                link.appendChild(fileIcon);
                                
                                const titleSpan = document.createElement('span');
                                titleSpan.style.whiteSpace = 'nowrap';
                                titleSpan.style.overflow = 'hidden';
                                titleSpan.style.textOverflow = 'ellipsis';
                                titleSpan.title = post.title;
                                titleSpan.textContent = post.title;
                                link.appendChild(titleSpan);
                                
                                if (post.status === 'draft') {
                                    const draftBadge = document.createElement('span');
                                    draftBadge.className = 'post-badge post-badge-draft';
                                    draftBadge.style.fontSize = '9px';
                                    draftBadge.style.padding = '1px 4px';
                                    draftBadge.style.marginLeft = '4px';
                                    draftBadge.style.background = '#fee2e2';
                                    draftBadge.style.color = '#991b1b';
                                    draftBadge.style.border = '1px solid #fca5a5';
                                    draftBadge.style.borderRadius = '4px';
                                    draftBadge.textContent = 'Draft';
                                    link.appendChild(draftBadge);
                                }
                                
                                nodeDiv.appendChild(link);
                                li.appendChild(nodeDiv);
                                subList.appendChild(li);
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Failed to load tree posts:', err);
                        loadingItem.innerHTML = '<span style="color: #ef4444;">Failed to load</span>';
                        subList.removeAttribute('data-loaded');
                    });
            }
        }
    }

    let currentQuickViewFontSize = 18;
    const postCache = {};

    function prefetchAllPosts() {
        document.querySelectorAll('[data-post-id]').forEach(el => {
            const id = el.getAttribute('data-post-id');
            if (id && !postCache[id]) {
                // Initialize cache slot with loading state or null to prevent duplicate requests
                postCache[id] = 'fetching';
                fetch('<?= URLROOT ?>/admin/get_post_ajax/' + id)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.success) {
                            postCache[id] = data;
                        } else {
                            delete postCache[id];
                        }
                    })
                    .catch(err => {
                        console.error('Prefetch error for post ' + id, err);
                        delete postCache[id];
                    });
            }
        });
    }

    function renderPostDetail(data) {
        const titleEl = document.getElementById('detailViewTitle');
        const bodyEl = document.getElementById('detailViewContent');
        const imgContainer = document.getElementById('detailViewImageContainer');
        const imgEl = document.getElementById('detailViewImage');
        const dateEl = document.getElementById('detailViewDate');
        const statusEl = document.getElementById('detailViewStatus');
        const tocContainer = document.getElementById('quickViewTocContainer');
        const tocContent = document.getElementById('quickViewTocContent');
        const fontDisplayEl = document.getElementById('fontSizeDisplay');

        titleEl.textContent = data.title;
        
        // Parse and format double brackets into footnotes
        let contentHtml = data.content;
        const regex = /\(\(\s*([^)]+?)\s*\)\)/g;
        let match;
        const footnotes = [];
        let index = 1;
        
        while ((match = regex.exec(contentHtml)) !== null) {
            const rawRef = match[1];
            let displayText = rawRef;
            let linkText = '';
            
            if (rawRef.includes('|')) {
                const parts = rawRef.split('|');
                displayText = parts[0].trim();
                linkText = parts[1].trim();
            }
            
            footnotes.push({
                index: index,
                displayText: displayText,
                linkText: linkText
            });
            
            const escapedText = displayText.replace(/"/g, '&quot;');
            let inlineHtml = displayText;
            if (linkText) {
                inlineHtml = `<a href="${linkText}" target="_blank" style="color: #2563eb; text-decoration: underline;">${displayText}</a>`;
            }
            const replacement = `${inlineHtml} <sup><a href="#admin-ref-note-${index}" id="admin-ref-link-${index}" class="footnote-ref-link" title="${escapedText}" data-tooltip="${escapedText}" style="color: #2563eb; font-weight: 700; text-decoration: none; padding: 0 2px;">[${index}]</a></sup>`;
            contentHtml = contentHtml.replace(match[0], replacement);
            regex.lastIndex -= match[0].length - replacement.length;
            index++;
        }
        
        bodyEl.innerHTML = contentHtml;

        const wrapPartsIntoCards = (containerEl) => {
            const children = Array.from(containerEl.childNodes);
            containerEl.innerHTML = '';
            
            let currentCard = null;
            
            children.forEach(child => {
                if (child.nodeType === 1 && child.tagName.toLowerCase() === 'h2') {
                    currentCard = document.createElement('div');
                    currentCard.className = 'post-part-card';
                    containerEl.appendChild(currentCard);
                }
                
                if (!currentCard) {
                    if (child.nodeType === 3 && child.textContent.trim() === '') {
                        return;
                    }
                    currentCard = document.createElement('div');
                    currentCard.className = 'post-part-card';
                    containerEl.appendChild(currentCard);
                }
                
                currentCard.appendChild(child);
            });
        };
        wrapPartsIntoCards(bodyEl);

        dateEl.textContent = data.created_at;
        statusEl.textContent = data.status.toUpperCase();
        statusEl.className = data.status === 'published' ? 'post-badge post-badge-published' : 'post-badge post-badge-draft';
        
        if (footnotes.length > 0) {
            const footnoteContainer = document.createElement('div');
            footnoteContainer.className = 'post-footnotes-box';
            footnoteContainer.style.marginTop = '40px';
            footnoteContainer.style.padding = '24px';
            footnoteContainer.style.background = '#f8fafc';
            footnoteContainer.style.border = '1px solid #e2e8f0';
            footnoteContainer.style.borderRadius = '16px';
            
            let footnoteHtml = `<h4 style="margin: 0 0 16px 0; font-size: 1.15rem; font-weight: 800; color: #1e293b; border-bottom: 2px solid #cbd5e1; padding-bottom: 8px;"><i class="fas fa-bookmark" style="color: #2563eb; margin-right: 8px;"></i>তথ্যসূত্র ও নোট (References)</h4>`;
            footnoteHtml += `<ol style="margin: 0; padding-left: 20px; font-size: 0.95rem; line-height: 1.8; color: #475569;">`;
            
            footnotes.forEach(fn => {
                let text = fn.displayText;
                if (fn.linkText) {
                    text = `<a href="${fn.linkText}" target="_blank" style="color: #2563eb; text-decoration: underline;">${fn.displayText}</a>`;
                }
                footnoteHtml += `<li id="admin-ref-note-${fn.index}" style="margin-bottom: 8px; padding-left: 4px;">
                    ${text} 
                    <a href="#admin-ref-link-${fn.index}" style="color: #2563eb; text-decoration: none; margin-left: 6px; font-weight: bold;" title="Back to text">↵</a>
                </li>`;
            });
            
            footnoteHtml += `</ol>`;
            footnoteContainer.innerHTML = footnoteHtml;
            bodyEl.appendChild(footnoteContainer);
        }
        
        if (data.image) {
            imgEl.src = data.image;
            imgContainer.style.display = 'block';
        } else {
            imgContainer.style.display = 'none';
        }

        // Generate short public frontend link (e.g. /p/[id])
        const shortLink = '<?= URLROOT ?>/p/' + data.id;
        const publicLink = '<?= URLROOT ?>/' + data.slug;
        window.currentPostPublicLink = shortLink;
        
        // Set social media links
        document.getElementById('shareFB').href = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(publicLink);
        document.getElementById('shareWA').href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(data.title + ' ' + publicLink);
        document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(publicLink) + '&text=' + encodeURIComponent(data.title);
        
        document.getElementById('detailShareGroup').style.display = 'flex';

        // Generate TOC for the sidebar
        if (tocContainer && tocContent) {
            tocContent.innerHTML = '';
            const headings = bodyEl.querySelectorAll('h2, h3, h4');
            if (headings.length >= 1) {
                const tocList = document.createElement('ol');
                tocList.className = 'toc-list';
                
                const toBangla = (num) => {
                    const banglaDigits = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
                    return num.toString().split('').map(digit => banglaDigits[digit] || digit).join('');
                };

                let h2Count = 0;
                let h3Count = 0;
                let h4Count = 0;

                headings.forEach((heading, idx) => {
                    const headingId = 'admin-heading-sec-' + idx;
                    heading.id = headingId;
                    heading.style.scrollMarginTop = '24px';

                    const level = heading.tagName.toLowerCase();
                    let numberPrefix = '';

                    if (level === 'h2') {
                        h2Count++;
                        h3Count = 0;
                        h4Count = 0;
                        numberPrefix = toBangla(h2Count) + '. ';
                    } else if (level === 'h3') {
                        h3Count++;
                        h4Count = 0;
                        numberPrefix = toBangla(h2Count) + '.' + toBangla(h3Count) + '. ';
                    } else if (level === 'h4') {
                        h4Count++;
                        numberPrefix = toBangla(h2Count) + '.' + toBangla(h3Count) + '.' + toBangla(h4Count) + '. ';
                    }

                    const listItem = document.createElement('li');
                    listItem.className = 'toc-item toc-' + level;
                    
                    const link = document.createElement('a');
                    link.href = '#' + headingId;
                    link.innerHTML = '<span class="toc-number">' + numberPrefix + '</span>' + heading.textContent;
                    
                    // Prepend the prefix to the actual heading on the page if not already present
                    if (!heading.innerHTML.includes('toc-heading-prefix')) {
                        heading.innerHTML = '<span class="toc-heading-prefix">' + numberPrefix + '</span>' + heading.innerHTML;
                    }

                    link.addEventListener('click', function(clickEvent) {
                        clickEvent.preventDefault();
                        heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        heading.classList.add('highlight-heading');
                        setTimeout(() => heading.classList.remove('highlight-heading'), 2000);
                    });

                    listItem.appendChild(link);
                    tocList.appendChild(listItem);
                });

                tocContent.appendChild(tocList);
                tocContainer.style.display = 'block';
                const sidebarEl = document.querySelector('.explorer-sidebar');
                if (sidebarEl) {
                    sidebarEl.classList.add('has-toc');
                    adjustSidebarFixedPosition();
                }
            } else {
                tocContainer.style.display = 'none';
                const sidebarEl = document.querySelector('.explorer-sidebar');
                if (sidebarEl) {
                    sidebarEl.classList.remove('has-toc');
                    adjustSidebarFixedPosition();
                }
            }
        }
    }

    function openQuickView(e, id) {
        e.preventDefault();
        e.stopPropagation();
        
        try {
            // Highlight current post in tree and table
            document.querySelectorAll('.post-node, tr[data-post-id]').forEach(el => {
                el.classList.remove('active-post');
            });
            document.querySelectorAll('[data-post-id="' + id + '"]').forEach(el => {
                el.classList.add('active-post');
            });
            
            // Auto-expand folder parent tree list if collapsed to make selected post visible in sidebar
            const activeNode = document.querySelector('.post-node.active-post');
            if (activeNode) {
                let parentList = activeNode.closest('.folder-tree-list');
                while (parentList) {
                    parentList.classList.remove('collapsed');
                    parentList.style.display = 'block';
                    
                    // Also turn the chevron icon down
                    const parentNode = parentList.previousElementSibling;
                    if (parentNode) {
                        const chevron = parentNode.querySelector('.folder-tree-toggle i');
                        if (chevron) {
                            chevron.className = 'fas fa-chevron-down';
                        }
                    }
                    parentList = parentList.parentElement.closest('.folder-tree-list');
                }
            }

            const listPanel = document.getElementById('explorerListView');
            const detailPanel = document.getElementById('explorerPostDetailView');
            if (!listPanel || !detailPanel) return;
            
            const titleEl = document.getElementById('detailViewTitle');
            const bodyEl = document.getElementById('detailViewContent');
            const imgContainer = document.getElementById('detailViewImageContainer');
            const dateEl = document.getElementById('detailViewDate');
            const statusEl = document.getElementById('detailViewStatus');
            const fontDisplayEl = document.getElementById('fontSizeDisplay');
            
            currentQuickViewFontSize = 18;
            bodyEl.style.fontSize = '18px';
            if (fontDisplayEl) {
                fontDisplayEl.textContent = '18px';
            }
            
            // Toggle view panels
            listPanel.style.display = 'none';
            detailPanel.style.display = 'block';

            // Check postCache first
            if (postCache[id] && postCache[id] !== 'fetching') {
                renderPostDetail(postCache[id]);
            } else {
                titleEl.textContent = "Loading...";
                bodyEl.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #2563eb;"></i></div>';
                imgContainer.style.display = 'none';
                dateEl.textContent = '';
                statusEl.textContent = '';
                statusEl.className = '';
                
                const tocContainer = document.getElementById('quickViewTocContainer');
                if (tocContainer) {
                    tocContainer.style.display = 'none';
                }

                const fetchUrl = '<?= URLROOT ?>/admin/get_post_ajax/' + id;
                fetch(fetchUrl)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('HTTP Status ' + res.status);
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            postCache[id] = data;
                            renderPostDetail(data);
                        } else {
                            titleEl.textContent = "Error";
                            bodyEl.innerHTML = '<p style="color: #ef4444;">' + (data.error || 'Failed to load post content.') + '</p>';
                            document.getElementById('detailShareGroup').style.display = 'none';
                        }
                    })
                    .catch(err => {
                        titleEl.textContent = "Error";
                        bodyEl.innerHTML = '<p style="color: #ef4444;">An error occurred while fetching the post: ' + err.message + '</p>';
                        document.getElementById('detailShareGroup').style.display = 'none';
                    });
            }
        } catch (err) {
            console.error('Reader Panel Error: ' + err.message);
        }
    }

    function closePostDetailView() {
        stopAudioReader();
        const listPanel = document.getElementById('explorerListView');
        const detailPanel = document.getElementById('explorerPostDetailView');
        if (listPanel && detailPanel) {
            detailPanel.style.display = 'none';
            listPanel.style.display = 'block';
            
            // Clear highlights when returning to folder view
            document.querySelectorAll('.post-node, tr[data-post-id]').forEach(el => {
                el.classList.remove('active-post');
            });

            // Hide the sidebar TOC container
            const tocContainer = document.getElementById('quickViewTocContainer');
            if (tocContainer) {
                tocContainer.style.display = 'none';
            }
            const sidebarEl = document.querySelector('.explorer-sidebar');
            if (sidebarEl) {
                sidebarEl.classList.remove('has-toc');
                adjustSidebarFixedPosition();
            }
        }
    }

    function changeFontSize(delta) {
        currentQuickViewFontSize += delta;
        if (currentQuickViewFontSize < 12) currentQuickViewFontSize = 12;
        if (currentQuickViewFontSize > 28) currentQuickViewFontSize = 28;
        
        const contentEl = document.getElementById('detailViewContent');
        if (contentEl) {
            contentEl.style.fontSize = currentQuickViewFontSize + 'px';
        }
        
        const fontDisplayEl = document.getElementById('fontSizeDisplay');
        if (fontDisplayEl) {
            fontDisplayEl.textContent = currentQuickViewFontSize + 'px';
        }
    }

    function copyPostPublicLink() {
        if (!window.currentPostPublicLink) return;
        
        navigator.clipboard.writeText(window.currentPostPublicLink)
            .then(() => {
                const copyBtnSpan = document.getElementById('copyLinkText');
                if (copyBtnSpan) {
                    copyBtnSpan.textContent = 'Copied!';
                    setTimeout(() => {
                        copyBtnSpan.textContent = 'Copy Link';
                    }, 2000);
                }
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
    }

    let ttsQueue = [];
    let ttsCurrentIndex = 0;
    let isTtsPlaying = false;
    let isTtsPaused = false;

    function detectLanguage(text) {
        if (/[\u0600-\u06FF]/.test(text)) {
            return 'ar';
        }
        if (/[\u0980-\u09FF]/.test(text)) {
            return 'bn';
        }
        return 'en';
    }

    function toggleAudioReader() {
        const playIcon = document.getElementById('audioPlayIcon');
        const playText = document.getElementById('audioPlayText');
        const contentEl = document.getElementById('detailViewContent');
        const titleEl = document.getElementById('detailViewTitle');
        const player = document.getElementById('ttsAudioPlayer');
        const floatIcon = document.getElementById('quickViewFloatingAudioIcon');
        const floatBtn = document.getElementById('quickViewFloatingAudioBtn');

        if (!player) {
            alert("অডিও প্লেয়ার লোড হতে পারেনি।");
            return;
        }

        if (isTtsPlaying) {
            if (isTtsPaused) {
                if (window.speechSynthesis && window.speechSynthesis.speaking) {
                    window.speechSynthesis.resume();
                } else {
                    player.play().then(() => {
                        player.playbackRate = 1.15;
                    }).catch(err => console.error("Resume failed:", err));
                }
                isTtsPaused = false;
                if (playIcon) playIcon.className = 'fas fa-pause';
                if (playText) playText.textContent = 'Pause';
                if (floatIcon) floatIcon.className = 'fas fa-pause';
                if (floatBtn) {
                    floatBtn.style.background = '#dc2626'; // Red when playing
                    floatBtn.title = "পজ করুন";
                }
            } else {
                if (window.speechSynthesis && window.speechSynthesis.speaking) {
                    window.speechSynthesis.pause();
                } else {
                    player.pause();
                }
                isTtsPaused = true;
                if (playIcon) playIcon.className = 'fas fa-play';
                if (playText) playText.textContent = 'Resume';
                if (floatIcon) floatIcon.className = 'fas fa-play';
                if (floatBtn) {
                    floatBtn.style.background = '#2563eb'; // Blue when paused
                    floatBtn.title = "পুনরায় শুনুন";
                }
            }
        } else {
            // Get selected text if any
            let textToRead = window.getSelection().toString().trim();
            
            // Fallback to structured title + headings/paragraphs if nothing is selected
            if (!textToRead) {
                let parts = [];
                if (titleEl && titleEl.innerText.trim()) {
                    parts.push(titleEl.innerText.trim() + " ।");
                }
                if (contentEl) {
                    const blocks = contentEl.querySelectorAll('h1, h2, h3, h4, h5, h6, p, li');
                    if (blocks.length > 0) {
                        blocks.forEach(block => {
                            const txt = block.innerText.trim();
                            if (txt) {
                                // Add a Bengali full stop if it doesn't end with punctuation
                                if (!/[।\?\!\.]/.test(txt.slice(-1))) {
                                    parts.push(txt + " ।");
                                } else {
                                    parts.push(txt);
                                }
                            }
                        });
                    } else {
                        parts.push(contentEl.innerText);
                    }
                }
                textToRead = parts.join("\n");
            }
            
            if (!textToRead.trim()) return;

            textToRead = textToRead.replace(/[\uFDFA\uFDFB]/g, "").replace(/[\uD83C-\uDBFF\uDC00-\uDFFF\u2600-\u27BF]/g, "");

            // Split text strictly into chunks under 100 characters for Google TTS safety
            let newQueue = [];
            let words = textToRead.split(/\s+/);
            let currentChunk = "";
            
            for (let word of words) {
                if ((currentChunk + " " + word).length < 100) {
                    currentChunk = currentChunk ? (currentChunk + " " + word) : word;
                } else {
                    if (currentChunk.trim()) {
                        newQueue.push(currentChunk.trim());
                    }
                    currentChunk = word;
                }
            }
            if (currentChunk.trim()) {
                newQueue.push(currentChunk.trim());
            }

            if (newQueue.length === 0) return;

            const wasSpeaking = window.speechSynthesis && (window.speechSynthesis.speaking || window.speechSynthesis.pending);

            if (wasSpeaking) {
                stopAudioReader(true);
                setTimeout(() => {
                    ttsQueue = newQueue;
                    ttsCurrentIndex = 0;
                    isTtsPlaying = true;
                    isTtsPaused = false;
                    
                    if (playIcon) playIcon.className = 'fas fa-pause';
                    if (playText) playText.textContent = 'Pause';
                    if (floatIcon) floatIcon.className = 'fas fa-pause';
                    if (floatBtn) {
                        floatBtn.style.background = '#dc2626';
                        floatBtn.title = "পজ করুন";
                    }
                    
                    playNextTtsChunk();
                }, 100);
            } else {
                stopAudioReader(false);
                
                ttsQueue = newQueue;
                ttsCurrentIndex = 0;
                isTtsPlaying = true;
                isTtsPaused = false;
                
                if (playIcon) playIcon.className = 'fas fa-pause';
                if (playText) playText.textContent = 'Pause';
                if (floatIcon) floatIcon.className = 'fas fa-pause';
                if (floatBtn) {
                    floatBtn.style.background = '#dc2626';
                    floatBtn.title = "পজ করুন";
                }
                
                playNextTtsChunk();
            }
        }
    }

    function playNextTtsChunk() {
        const player = document.getElementById('ttsAudioPlayer');
        if (!player || !isTtsPlaying || ttsCurrentIndex >= ttsQueue.length) {
            stopAudioReader(false);
            return;
        }

        const chunkText = ttsQueue[ttsCurrentIndex] ? ttsQueue[ttsCurrentIndex].trim() : '';
        if (!chunkText) {
            ttsCurrentIndex++;
            playNextTtsChunk();
            return;
        }

        const lang = detectLanguage(chunkText);

        const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

        if (isLocalhost) {
            // Fetch from local proxy as primary
            const url = "<?= URLROOT ?>/proxy_tts?lang=" + lang + "&text=" + encodeURIComponent(chunkText);
            player.src = url;
            
            player.onended = () => {
                ttsCurrentIndex++;
                playNextTtsChunk();
            };

            player.onerror = (e) => {
                console.warn("Proxy Google TTS failed, falling back to browser SpeechSynthesis...", e);
                playNativeSpeechFallback(chunkText, lang);
            };

            player.play().then(() => {
                player.playbackRate = 1.15;
            }).catch(err => {
                console.warn("Proxy audio playback failed/blocked, falling back to browser SpeechSynthesis...", err);
                playNativeSpeechFallback(chunkText, lang);
            });
        } else {
            // On live server, use browser SpeechSynthesis directly to avoid VPS proxy blocks
            // and keep speech calls inside the synchronous user gesture event flow.
            playNativeSpeechFallback(chunkText, lang);
        }
    }

    function playNativeSpeechFallback(chunkText, lang) {
        if (!window.speechSynthesis) {
            ttsCurrentIndex++;
            playNextTtsChunk();
            return;
        }
        
        const utterance = new SpeechSynthesisUtterance(chunkText);
        let langTag = 'en-US';
        if (lang === 'bn') {
            langTag = 'bn-BD';
        } else if (lang === 'ar') {
            langTag = 'ar-SA';
        }
        utterance.lang = langTag;
        utterance.rate = 1.05;

        const voices = window.speechSynthesis.getVoices();
        let selectedVoice = voices.find(v => v.lang.toLowerCase().startsWith(lang)) || 
                            voices.find(v => v.lang.toLowerCase().includes(lang));
        if (selectedVoice) {
            utterance.voice = selectedVoice;
        }

        utterance.onend = () => {
            ttsCurrentIndex++;
            playNextTtsChunk();
        };
        utterance.onerror = (err) => {
            console.warn("SpeechSynthesis fallback error:", err);
            ttsCurrentIndex++;
            playNextTtsChunk();
        };

        window.speechSynthesis.speak(utterance);
    }

    function stopAudioReader(callCancel = true) {
        isTtsPlaying = false;
        isTtsPaused = false;
        const player = document.getElementById('ttsAudioPlayer');
        if (player) {
            player.pause();
            player.src = '';
        }
        if (callCancel && window.speechSynthesis) {
            window.speechSynthesis.cancel();
        }
        ttsQueue = [];
        ttsCurrentIndex = 0;
        resetAudioState();
    }

    function resetAudioState() {
        const playIcon = document.getElementById('audioPlayIcon');
        const playText = document.getElementById('audioPlayText');
        const floatIcon = document.getElementById('quickViewFloatingAudioIcon');
        const floatBtn = document.getElementById('quickViewFloatingAudioBtn');

        if (playIcon && playText) {
            playIcon.className = 'fas fa-play';
            playText.textContent = 'Listen';
        }
        if (floatIcon) {
            floatIcon.className = 'fas fa-headphones';
        }
        if (floatBtn) {
            floatBtn.style.background = '#2563eb';
            floatBtn.title = "আর্টিকেল শুনুন";
        }
    }
</script>

<!-- SortableJS for folder drag-and-drop -->
<script src="<?= URLROOT ?>/public/js/Sortable.min.js"></script>
<script>window.Sortable || document.write('<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"><\/script>')</script>
<script>
(function() {
    let sortableInstances = [];
    let dragModeActive = false;

    function saveFolderOrder(sortableList) {
        const items = sortableList.querySelectorAll(':scope > li.folder-tree-item[data-cat-id]');
        const ids = Array.from(items).map(el => parseInt(el.dataset.catId)).filter(Boolean);
        if (ids.length === 0) return;
        fetch('<?= URLROOT ?>/admin/reorder_categories', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ids: ids })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                sortableList.style.transition = 'opacity 0.2s';
                sortableList.style.opacity = '0.5';
                setTimeout(() => { sortableList.style.opacity = '1'; }, 200);
            }
        })
        .catch(e => console.error('Reorder failed', e));
    }

    function initSortable(ulEl) {
        if (!ulEl) return;
        if (typeof Sortable === 'undefined') {
            console.warn('SortableJS is not loaded. Drag-and-drop ordering disabled.');
            return;
        }
        const instance = Sortable.create(ulEl, {
            animation: 150,
            handle: '.folder-drag-handle',
            draggable: '.folder-tree-item',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            filter: '.non-draggable',
            disabled: !dragModeActive,
            group: 'nested-folders',
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function(evt) {
                const itemEl = evt.item;
                const toList = evt.to;
                const fromList = evt.from;
                
                const catId = itemEl.dataset.catId;
                const newParentId = toList.dataset.parentId || null;
                
                const siblingItems = toList.querySelectorAll(':scope > li.folder-tree-item[data-cat-id]');
                const siblingIds = Array.from(siblingItems).map(el => parseInt(el.dataset.catId)).filter(Boolean);
                
                fetch('<?= URLROOT ?>/admin/move_and_reorder_category', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: catId,
                        parent_id: newParentId,
                        sibling_ids: siblingIds
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        toList.style.transition = 'opacity 0.2s';
                        toList.style.opacity = '0.5';
                        setTimeout(() => { toList.style.opacity = '1'; }, 200);
                        if (fromList !== toList) {
                            fromList.style.transition = 'opacity 0.2s';
                            fromList.style.opacity = '0.5';
                            setTimeout(() => { fromList.style.opacity = '1'; }, 200);
                        }
                    } else if (data.message) {
                        alert(data.message);
                        window.location.reload();
                    }
                })
                .catch(e => {
                    console.error('Drag movement failed', e);
                    window.location.reload();
                });
            }
        });
        sortableInstances.push(instance);
    }

    function initAllSortables() {
        // Destroy existing instances first to avoid duplicate bindings
        sortableInstances.forEach(inst => inst.destroy());
        sortableInstances = [];

        document.querySelectorAll('.folder-tree-list').forEach(ul => {
            initSortable(ul);
        });
    }

    function adjustSidebarFixedPosition() {
        const sidebar = document.querySelector('.explorer-sidebar');
        if (sidebar) {
            if (window.innerWidth <= 1200) {
                sidebar.style.top = '';
                sidebar.style.maxHeight = '';
                sidebar.style.height = '';
                return;
            }
            const currentHeightCalc = 'calc(100vh - 24px)';
            sidebar.style.top = '12px';
            sidebar.style.maxHeight = currentHeightCalc;
            
            // Force resolved height when TOC is shown so flex 50/50 split works
            if (sidebar.classList.contains('has-toc')) {
                sidebar.style.height = currentHeightCalc;
            } else {
                sidebar.style.height = 'auto';
            }
        }
    }

    // Export to window so AJAX loader and global handlers can call them without error
    window.initAllSortables = initAllSortables;
    window.adjustSidebarFixedPosition = adjustSidebarFixedPosition;

    function applySidebarPreferences() {
        const sidebar = document.querySelector('.explorer-sidebar');
        const btnTogglePosts = document.getElementById('btn-toggle-posts');
        const btnAdjust = document.getElementById('btn-adjust-folders');
        if (!sidebar) return;

        // 1. Posts preference
        const hidePostsPref = localStorage.getItem('hidePostsInTree') === 'true';
        if (hidePostsPref) {
            sidebar.classList.add('hide-posts-in-tree');
            if (btnTogglePosts) {
                btnTogglePosts.innerHTML = '<i class="fas fa-eye-slash"></i> Posts';
                btnTogglePosts.classList.remove('btn-explorer-secondary');
                btnTogglePosts.classList.add('btn-explorer-primary');
                btnTogglePosts.style.backgroundColor = '#64748b';
                btnTogglePosts.style.borderColor = '#64748b';
            }
        } else {
            sidebar.classList.remove('hide-posts-in-tree');
            if (btnTogglePosts) {
                btnTogglePosts.innerHTML = '<i class="fas fa-eye"></i> Posts';
                btnTogglePosts.classList.remove('btn-explorer-primary');
                btnTogglePosts.classList.add('btn-explorer-secondary');
                btnTogglePosts.style.backgroundColor = '';
                btnTogglePosts.style.borderColor = '';
            }
        }

        // 2. Adjust/Drag Mode preference
        if (dragModeActive) {
            sidebar.classList.add('drag-active');
            if (btnAdjust) {
                btnAdjust.innerHTML = '<i class="fas fa-check"></i> Done';
                btnAdjust.classList.remove('btn-explorer-secondary');
                btnAdjust.classList.add('btn-explorer-primary');
            }
        } else {
            sidebar.classList.remove('drag-active');
            if (btnAdjust) {
                btnAdjust.innerHTML = '<i class="fas fa-arrows-alt"></i> Adjust';
                btnAdjust.classList.remove('btn-explorer-primary');
                btnAdjust.classList.add('btn-explorer-secondary');
            }
        }
    }

    // Delegated click listeners for sidebar buttons
    document.addEventListener('click', function(e) {
        const btnTogglePosts = e.target.closest('#btn-toggle-posts');
        if (btnTogglePosts) {
            const sidebar = document.querySelector('.explorer-sidebar');
            if (sidebar) {
                const isHidden = sidebar.classList.toggle('hide-posts-in-tree');
                localStorage.setItem('hidePostsInTree', isHidden);
                applySidebarPreferences();
            }
            return;
        }

        const btnAdjust = e.target.closest('#btn-adjust-folders');
        if (btnAdjust) {
            const sidebar = document.querySelector('.explorer-sidebar');
            if (sidebar) {
                dragModeActive = !dragModeActive;
                applySidebarPreferences();
                sortableInstances.forEach(inst => {
                    inst.option('disabled', !dragModeActive);
                });
            }
            return;
        }

        const toggleBtn = e.target.closest('.btn-show-mode-toggle');
        if (toggleBtn) {
            const nextMode = toggleBtn.getAttribute('data-next-mode');
            document.cookie = "show_mode=" + nextMode + "; path=/; max-age=" + (86400 * 30);
            return;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        initAllSortables();
        applySidebarPreferences();
        adjustSidebarFixedPosition();
        // prefetchAllPosts(); // Disabled to optimize CPU & RAM usage
        window.addEventListener('resize', adjustSidebarFixedPosition);
    });

    // Re-init when tree branches are expanded
    document.addEventListener('click', function(e) {
        if (e.target.closest('.folder-tree-toggle')) {
            setTimeout(initAllSortables, 100);
        }
    });

    // --- AJAX Explorer Loader Logic ---
    let lastUrlWithoutHash = window.location.pathname + window.location.search;

    function loadCategoryPage(url, shouldPushState = true) {
        // Hide the sidebar TOC container
        const tocContainer = document.getElementById('quickViewTocContainer');
        if (tocContainer) {
            tocContainer.style.display = 'none';
        }
        const sidebarEl = document.querySelector('.explorer-sidebar');
        if (sidebarEl) {
            sidebarEl.classList.remove('has-toc');
        }

        const layout = document.querySelector('.explorer-layout');
        const header = document.querySelector('.explorer-header');
        if (layout) layout.style.opacity = '0.5';
        if (header) header.style.opacity = '0.5';

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // 1. Update header
                const newHeader = doc.querySelector('.explorer-header');
                if (newHeader && header) {
                    header.innerHTML = newHeader.innerHTML;
                }

                // 2. Update explorer main content (breadcrumbs, subfolders, articles, pagination)
                const newMain = doc.querySelector('.explorer-main');
                const currentMain = document.querySelector('.explorer-main');
                if (newMain && currentMain) {
                    currentMain.innerHTML = newMain.innerHTML;
                }

                // 3. Update sidebar folder tree card (keeps active states, expansions, and header button synced)
                const newSidebarCard = doc.getElementById('sidebar-tree-card');
                const currentSidebarCard = document.getElementById('sidebar-tree-card');
                if (newSidebarCard && currentSidebarCard) {
                    currentSidebarCard.innerHTML = newSidebarCard.innerHTML;
                }

                // 4. Update the sidebar Root Folder node active state
                const newRootNode = doc.querySelector('.folder-tree-node');
                const currentRootNode = document.querySelector('.folder-tree-node');
                if (newRootNode && currentRootNode) {
                    currentRootNode.className = newRootNode.className;
                }

                // 5. Update modals hidden inputs (sync parent category and category IDs after AJAX navigation)
                const newNewFolderParent = doc.querySelector('#newFolderModal input[name="parent_id"]');
                const currentNewFolderParent = document.querySelector('#newFolderModal input[name="parent_id"]');
                if (newNewFolderParent && currentNewFolderParent) {
                    currentNewFolderParent.value = newNewFolderParent.value;
                }

                const newImportDocCategory = doc.querySelector('#importDocModal input[name="category_id"]');
                const currentImportDocCategory = document.querySelector('#importDocModal input[name="category_id"]');
                if (newImportDocCategory && currentImportDocCategory) {
                    currentImportDocCategory.value = newImportDocCategory.value;
                }

                const newRenameParent = doc.querySelector('#rename_parent_id');
                const currentRenameParent = document.getElementById('rename_parent_id');
                if (newRenameParent && currentRenameParent) {
                    currentRenameParent.value = newRenameParent.value;
                }

                const newMoveFolderModal = doc.getElementById('moveFolderModal');
                const currentMoveFolderModal = document.getElementById('moveFolderModal');
                if (newMoveFolderModal && currentMoveFolderModal) {
                    currentMoveFolderModal.innerHTML = newMoveFolderModal.innerHTML;
                }

                // 6. Update URL in address bar
                if (shouldPushState) {
                    history.pushState(null, '', url);
                    try {
                        const parsedUrl = new URL(url, window.location.origin);
                        lastUrlWithoutHash = parsedUrl.pathname + parsedUrl.search;
                    } catch (e) {
                        lastUrlWithoutHash = url;
                    }
                }

                // Re-initialize sortables on the newly loaded lists
                initAllSortables();
                applySidebarPreferences();
                // prefetchAllPosts(); // Disabled to optimize CPU & RAM usage
                // Recalculate fixed sidebar scroll offsets
                adjustSidebarFixedPosition();
            })
            .catch(error => {
                console.error('AJAX Load failed, falling back to full navigation:', error);
                window.location.href = url;
            })
            .finally(() => {
                if (layout) layout.style.opacity = '1';
                if (header) header.style.opacity = '1';
                adjustSidebarFixedPosition();
            });
    }

    // Intercept clicks on links that change categories / load pages
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link) {
            const href = link.getAttribute('href');
            if (href) {
                const isTarget = href.includes('/admin/posts') || 
                                 href.startsWith('?category_id=') || 
                                 (href.includes('category_id=') && href.includes('page='));
                
                if (isTarget) {
                    // Filter out non-navigation actions
                    if (!href.includes('/admin/edit_post') && 
                        !href.includes('/admin/delete_post') && 
                        !href.includes('/admin/delete_folder') &&
                        !href.includes('/admin/add_post')) {
                        
                        if (!e.ctrlKey && !e.metaKey && !e.shiftKey && !e.button) {
                            e.preventDefault();
                            loadCategoryPage(href);
                        }
                    }
                }
            }
        }

        // Intercept folder-card clicks
        const folderCard = e.target.closest('.folder-card');
        if (folderCard) {
            const href = folderCard.getAttribute('data-href');
            if (href) {
                e.preventDefault();
                loadCategoryPage(href);
            }
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const currentUrlWithoutHash = window.location.pathname + window.location.search;
        if (currentUrlWithoutHash === lastUrlWithoutHash) {
            return;
        }
        loadCategoryPage(window.location.href, false);
    });
})();
</script>

<?php require APPROOT . '/Views/admin/footer.php'; ?>

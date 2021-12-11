<div class="httemplates-templates-area">

    <!-- PopUp Content Start -->
    <div id="etwwpt-popup-area" style="display: none;">
        <div class="httemplate-popupcontent">
            <div class='etwwptspinner'></div>
            <div class="etwwptmessage" style="display: none;">
                <p></p>
                <span class="etwwpt-edit"></span>
            </div>
            <div class="etwwptpopupcontent">
                <ul class="etwwptemplata-requiredplugins"></ul>
                <p><?php esc_html_e( 'Import template to your Library', 'etww' ); ?></p>
                <span class="etwwptimport-button-dynamic"></span>
            </div>
        </div>
    </div>
    <!-- PopUp Content End -->

    <div id="etwwpt-search-section" class="etwwpt-search-section section">
        <div class="container-fluid">
            <form action="#" class="etwwpt-search-form">
                <div class="row">

                    <div class="col-md-auto col">
                        <div class="etwwpt-demos-select">
                            <select id="etwwpt-demos">
                                <option value="templates"><?php esc_html_e( 'Templates', 'etww' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-auto col">
                        <div class="etwwpt-builder-select">
                            <select id="etwwpt-builder">
                                <option value="all"><?php esc_html_e( 'All Builders', 'etww' ); ?></option>
                                <option value="elementor"><?php esc_html_e( 'Elementor', 'etww' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-auto mr-auto">
                        <input id="etwwpt-search-field" type="text" placeholder="<?php esc_attr_e( 'Search..', 'etww' );?>">
                    </div>
                    <div class="col-auto">
                        <div class="etwwpt-type-select">
                            <select id="etwwpt-type">
                                <option value="all"><?php esc_html_e( 'ALL', 'etww' ); ?></option>
                                <option value="free"><?php esc_html_e( 'Free', 'etww' ); ?></option>
                                <option value="pro"><?php esc_html_e( 'Pro', 'etww' ); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="etwwpt-project-section" class="etwwpt-project-section section">
        <div id="etwwpt-project-grid" class="etwwpt-project-grid row" style="overflow: hidden;">
            <h2 class="etwwpt-project-message"><span class="etwwpt-pro-loading2"></span></h2>
        </div>
        <div id="etwwpt-load-more-project" class="text-center"></div>
    </div>

    <div id="etwwpt-group-section">
        <div id="etwwpt-group-bar" class="etwwpt-group-bar">
            <span id="etwwpt-group-close" class="back"><i>&#8592;</i> <?php esc_html_e( 'Back to Library', 'etww' ); ?></span>
            <h3 id="etwwpt-group-name" class="title"></h3>
        </div>

        <div id="etwwpt-group-grid" class="row"></div>
        <a href="#top" class="etwwpt-groupScrollToTop"><?php echo esc_html__( 'Top', 'etww' );?></a>
    </div>

    <a href="#top" class="etwwpt-scrollToTop"><?php echo esc_html__( 'Top', 'etww' );?></a>

</div>
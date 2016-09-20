
<div class="control-panel">
    <div class="left-control-panel">
        <div class="sidebar">

            <?php generate_admin_tabs(); ?>



        </div>
    </div>

    <div class="right-control-panel">
        <div class="container-admin">


            <?php
            switch(get_admin_tab()){
                case 'dashboard' :
                    //load_dashboard_tab();
                    switch(get_user_type()){
                        
                        case 'host':
                            load_host_dashboard_tab();
                            break;
                        case 'restaurant_owner';
                            load_restaurant_dashboard_tab();
                            break;
                        case 'system_admin';
                            load_system_admin_dashboard_tab();
                            break;
                        default:
                            load_dashboard_tab();
                        break;
                    }
                    
                    break;
                case 'basic-info':
                    load_restaurant_info_tab();
                    break;
                case 'gallery':
                    load_restaurant_gallery_tab();
                    break;
                case 'hours':
                    load_restaurant_hours_tab();
                    break;
                case 'tables':
                    load_restaurant_tables_tab();
                    break;
                case 'reservations':
                    load_reservations_tab();
                    break;
                case 'employees':
                    load_restaurant_employees_tab();
                    break;
                case 'settings':
                    load_settings_tab();
                    break;
                default:
                    echo "Tab under construction";
                    break;
            }
            ?>




        </div>

    </div>

</div>
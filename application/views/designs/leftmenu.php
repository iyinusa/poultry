<?php
	if($page_act == 'dashboard'){$dashboard_active = 'active';}else{$dashboard_active = '';}
	if($page_act == 'branch'){$branch_active = 'active';}else{$branch_active = '';}
	if($page_act == 'feed'){$feed_active = 'active';}else{$feed_active = '';}
	if($page_act == 'livestock'){$livestock_active = 'active';}else{$livestock_active = '';}
	if($page_act == 'mortality'){$mortality_active = 'active';}else{$mortality_active = '';}
	if($page_act == 'egg'){$egg_active = 'active';}else{$egg_active = '';}
	if($page_act == 'report'){$report_active = 'active';}else{$report_active = '';}
?>

<!-- wrapper -->
<div class="wrapper">
    <div class="leftside">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="title">Navigation</li>
                <li class="<?php echo $dashboard_active; ?>">
                    <a href="<?php echo base_url(); ?>dashboard">
                        <i class="fa fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?php echo $branch_active; ?>">
                    <a href="<?php echo base_url(); ?>branch">
                        <i class="fa fa-bank"></i> <span>Branch</span>
                    </a>
                </li>
                <li class="<?php echo $feed_active; ?>">
                    <a href="<?php echo base_url(); ?>feeds">
                        <i class="fa fa-book"></i> <span>Feeds</span>
                    </a>
                </li>
                <li class="<?php echo $livestock_active; ?>">
                    <a href="<?php echo base_url(); ?>livestock">
                        <i class="fa fa-gears"></i> <span>Livestock</span>
                    </a>
                </li>
                <li class="<?php echo $mortality_active; ?>">
                    <a href="<?php echo base_url(); ?>mortality">
                        <i class="fa fa-edit"></i> <span>Mortality</span>
                    </a>
                </li>
                <li class="<?php echo $egg_active; ?>">
                    <a href="<?php echo base_url(); ?>eggs">
                        <i class="fa fa-user"></i> <span>Eggs</span>
                    </a>
                </li>
                <!--<li class="<?php echo $report_active; ?> sub-nav">
                    <a href="javascript:;">
                        <i class="fa fa-signal"></i> <span>Report</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>dashboard">Feeds</a></li>
                        <li><a href="<?php echo base_url(); ?>dashboard">Livestock</a></li>
                        <li><a href="<?php echo base_url(); ?>dashboard">Mortality</a></li>
                        <li><a href="<?php echo base_url(); ?>dashboard">Eggs</a></li>
                    </ul>
                </li>-->
            </ul>
         </div>
    </div>
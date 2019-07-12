{{! $user = Auth::guard('admin')->user() }}
{{! $userMenuList = Session::get('navigation_admin') }}
{{! $fieldname = getSessionLang() == 'en' ? 'en_name' : 'name' }}

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
			<li class="header nav-header"><?= transLang('main_navigation') ?></li>
			<?php if(count($userMenuList)) { ?>
				<?php foreach($userMenuList as $navigation) {?>
                    <?php if($navigation['show_in_menu'] == 1) { ?>
                        <?php if(isset($navigation['children']) && count($navigation['children'])) { ?>
                            <li class="treeview">
                                <a href="<?= URL::to($navigation['action_path']) ?>">
                                    <i class="<?= $navigation['icon'] ?>"></i> 
                                    <span><?= $navigation[$fieldname] ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
								<ul class="treeview-menu">
									<?php foreach($navigation['children'] as $sub_menu) { ?>
										<?php if($sub_menu['show_in_menu'] == 1) { ?>
											<li class="<?= Request::is("{$sub_menu['action_path']}*") ? 'active' : '' ?>">
												<a href="<?= URL::to($sub_menu['action_path']) ?>"><i class="fa fa-circle-o"></i><?= $sub_menu[$fieldname] ?></a>
											</li>
										<?php } ?>
									<?php } ?>
								</ul>
                            </li>
						<?php } else { ?>
                            <li class="<?= Request::is("{$navigation['action_path']}*") ? 'active' : '' ?>">
                                <a href="<?= URL::to($navigation['action_path']) ?>">
                                    <i class="<?= $navigation['icon'] ?>"></i> 
                                    <span><?= $navigation[$fieldname] ?></span>
                                </a>
                            </li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
        </ul>
    </section>
</aside>
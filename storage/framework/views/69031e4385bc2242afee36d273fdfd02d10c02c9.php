 <?php
$void = "javascript:void(0)";
?>
 <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
      <div class="nav-left-sidebar sidebar-dark" style="overflow-y: scroll;">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="javascript:void(0)">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarNav" aria-controls="sidebarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="sidebarNav">
                        <ul class="navbar-nav flex-column">
                           
							<?php
							$a = "active";
							 if(!is_null($user))
							 {
							  if($user->role == "admin")
							 {
								 $a = "";
							?>
							 <li class="nav-divider">
                                Admin
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo e(url('/')); ?>"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?php echo e($void); ?>" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-users"></i>Users</a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(url('users')); ?>">View users</a>                             
                                            <a class="nav-link" href="<?php echo e(url('new-user')); ?>">Add new user</a>                             
                                        </li>
                                    </ul>
                                </div>
                            </li>
							<?php
							 }
							?>
							<li class="nav-divider">
                                Webmail
                            </li>
							<li class="nav-item">
                                <a class="nav-link <?php echo e($a); ?>" href="<?php echo e(url('inbox')); ?>"><i class="fa fa-fw fa-inbox"></i>Inbox </a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" id="compose-btn" href="<?php echo e($void); ?>"><i class="fa fa-fw fa-plus"></i>Compose </a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('drafts')); ?>"><i class="fa fa-fw fa-edit"></i>Drafts </a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('sent')); ?>"><i class="fa fa-fw fa-paper-plane"></i>Sent </a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('trash')); ?>"><i class="fa fa-fw fa-trash"></i>Trash </a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('spam')); ?>"><i class="fa fa-fw fa-exclamation-triangle"></i>Spam </a>
                            </li>
							<?php
							 }
							?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
<?php /**PATH C:\bkupp\lokl\repo\ace-webmail-server\resources\views/sidebar.blade.php ENDPATH**/ ?>
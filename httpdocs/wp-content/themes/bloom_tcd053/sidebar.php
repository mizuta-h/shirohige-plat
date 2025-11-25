<?php
global $active_sidebar;
if ( ! $active_sidebar ) $active_sidebar = get_sidebar_id();
if ( $active_sidebar ) :
?>
		<aside class="p-sidebar l-secondary">
			<div class="p-sidebar__inner">
<?php
		dynamic_sidebar( $active_sidebar );
?>
			</div>
		</aside>
<?php
endif;

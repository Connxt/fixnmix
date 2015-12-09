<section class="sidebar">
    <ul class="sidebar-menu">
    	<li class="header">MAIN NAVIGATION</li>
        <li <?php if($current_page == "items") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'items'; ?>"> Items</a></li>
		<li <?php if($current_page == "item_distribution") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'item_distribution'; ?>"> Item Distribution</a></li>
		<li <?php if($current_page == "item_returns") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'item_returns'; ?>"> Item Returns</a></li>
		<li <?php if($current_page == "uncleared_items") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'uncleared_items'; ?>"> Uncleared Items</a></li>
        <li <?php if($current_page == "branches") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'branches'; ?>"> Branches</a></li>
		<li <?php if($current_page == "reports") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'reports'; ?>"> Reports</a></li>
		<li <?php if($current_page == "users") echo "class='active'"; ?> ><a href="<?php echo base_url() . 'users'; ?>"> Users</a></li>
    </ul>
</section>
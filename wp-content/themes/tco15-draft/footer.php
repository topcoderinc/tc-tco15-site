<footer id="footer" class="site-footer">
    
    <div class="container">
    <ul class="links">
        <?php        
        $menu = wp_get_nav_menu_object('Footer menu');
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $count = 0;
        foreach( (array) $menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            
            $page = get_post($menu_item->object_id);
            $slug = $page->post_name;
            $class = "";
            if($count%2 !=0){
                $class="alt";
            }
            $count += 1;
        ?>
        <li class="<?php echo $class; ?>"><a class="<?php echo $slug; ?>" href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
        <?php
        }
        ?>
    </ul><!-- end of .links -->
    <div class="poweredBy"><a class="tc" href="http://www.topcoder.com/"></a></div>
    </div>
</footer>

<!-- modal -->
<!--  <div id="modalBg"></div> -- end of #modalBg -->
<div id="registerModal" class="modal fade in" >
<div class="modal-dialog">
<div class="modal-content">
	<div >
	    <div class="modalBox">
	        <a class="close closeModal" href="javascript:;" data-dismiss="modal"></a>
	        <div class="loading" style="display: none;">Loading...</div>
	        <div class="boxContent register" id="register">
	            <?php 
	            $page = get_page_by_title( 'Join the Event' );
	            ?>
	            
	            
	            <form action="#" id="frmTCLogin">
	            <div class="inner">
	                <p class="error hide">Invalid handle/password combination.</p>
	                <div  class="row">
	                    <label>Handle </label>
	                    <div class="ipWrap">
	                    	<span class="inputbox"><input type="text" class="tiptext" placeholder="Handle" id="handle" /></span>
	                    </div>
	                </div>
	                <div  class="row">
	                    <label>Password </label>
	                    <div class="ipWrap">
	                    	<span class="inputbox"><input type="password" class="usr tiptext" placeholder="Password" id="password" /></span>
                    	</div> 
	                </div>
	                <div class="buttons">
	                    <a class="btn btn-primary regBtn" href="javascript:doLogin(false);">SIGN UP</a>
	                    <a class="btn btn-default cancel" href="javascript:;" data-dismiss="modal">CANCEL</a>
	                </div>
	                <p class="success hide">Register Complete !!</p>
                </div>
	            </form>
	            <p class="bottom">
	                Not already a topcoder member ?<br/>
	                <a href="http://www.topcoder.com/reg">Click here to register</a>
	            </p>
	        </div>
	        
	        <div class="registerSuc hide"> <!-- end of .registerSuc -->
	            <h1>Thanks for registration!</h1>
	            <p>You have already registered for the TCO14!</p>  
	             <div class="buttons">
	            <a class="btn btnSecondary closeModal closeAndClean" href="javascript:;" data-dismiss="modal">
	                <span class="buttonMask"><span class="text">Close</span></span>
	            </a>
	            </div>
	        </div>
	        <div class="agreementTerm hide">
				<p class="error hide">You must agree with the Terms and Conditions.</p>
	            <h2>Do you agree to the Terms and Conditions?</h2>
	            <ul>
	                <li>
	                    <div class="agreementWrapper">
	                    <?php
	                    $page = get_page_by_title( 'Terms and Conditions' );
	                    echo apply_filters('the_content', $page->post_content);
	                    ?>
	                    </div>
	                </li>
	                <li>
	                    <a class="btn btn-primary btn-sm" id="btnAgree" href="javascript:;">Yes </a>
	                    <a class="btn btn-default" id="rejectBtn" href="javascript:;">No</a>
	                </li>
	            </ul>
	        </div>
	    </div><!-- end of #registerModal -->
	</div><!-- end of #modalContent -->

</div></div>
</div>

<?php wp_footer(); ?> 
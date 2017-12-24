<?php


/**
* Creation of the metabox_id with the hyper-amazing KTT Framework
*/
$args = array();
$args['metabox_id'] 					    = 	'post_interview';
$args['metabox_name']					    = 	__("Interview", 'narratium');
$args['metabox_post_type'] 		    		= 	'post';
$args['metabox_vars'] 				    	= 	array(
                                        		'ktt_post_interview_interviewer',
                                        		'ktt_post_interview_interviewed'
                                      			);
$args['metabox_callback']         			= 	'KTT_interview_metabox';
$args['metabox_context']			    	= 	'normal';
$args['metabox_priority']		      		= 	'high';
$metabox = new KTT_new_metabox($args);




/**
* Interview metabox
*/
function KTT_interview_metabox($post) {

    ?>

    <p>
    	<?php _e('If this article includes an interview and special controls have been used to enter questions and answers, complete the following fields.', 'narratium');?>
    </p>

    <table class="form-table">
    	<tr valign="top">
    		<th ><?php _e('Interviewer','narratium')?>
    			<p class="description"><?php _e('insert the name of the <b>interviewer</b>','narratium')?></p>
    		</th>
    		<td>
    			<fieldset>

    				<input type="text" name="<?php echo 'ktt_post_interview_interviewer';?>" value="<?php echo get_post_meta($post->ID, 'ktt_post_interview_interviewed', true);?>">

    			</fieldset>
    		</td>
    	</tr>

    	<tr valign="top">
    		<th ><?php _e('Interviewed','narratium')?>
    			<p class="description"><?php _e('insert the name of the <b>interviewed</b>','narratium')?></p>
    		</th>
    		<td>
    			<fieldset>

    				<input type="text" name="<?php echo 'ktt_post_interview_interviewed';?>" value="<?php echo get_post_meta($post->ID, 'ktt_post_interview_interviewed', true);?>">

    			</fieldset>
    		</td>
    	</tr>


    </table>

    <?php

}








// add the css style for interview in the article page

add_filter('wp_head', 'KTT_print_css_interview_style');
function KTT_print_css_interview_style($content) {


	if (is_single()) {

		global $post;
		//if (isset($post->post_interview_interviewed) && $post->post_interview_interviewed) {
		?>
		<style>

		      .ktt-interview-question:before, .ktt-interview-answer:before {
		        position:absolute;
		        width:200px;
		        text-align:right;
		        margin-left:-220px;
		        font-size:0.65em;
		        font-weight:200;
		      }


		      @media  screen and (min-width : 0px) and (max-width : 768px) {
		        .ktt-interview-question:before, .ktt-interview-answer:before {
		          position:relative;
		          display:block;
		          text-align:left;
		          margin:0;
		        }
		      }

			.ktt-interview-question:before {
			     content:'<?php _e('Question','narratium');?>';
			}
			.ktt-interview-answer:before {
			     content:'<?php _e('Answer','narratium');?>';
			}


			<?php if ($post->post_interview_interviewer) {?>
			.ktt-interview-question:before {
			  	content:'<?php echo $post->post_interview_interviewer;?>';
			}
			<?php } ?>

			<?php if ($post->post_interview_interviewed) { ?>
			.ktt-interview-answer:before {
				content:'<?php echo $post->post_interview_interviewed;?>';
			}
			<?php } ?>

		</style>
		<?php //}

	}

	return $content;

}

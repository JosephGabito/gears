<?php
/*
 * Cover Photo crop template
 *
 * @package bp-cover-photo
 * @since 2.0
 */
?>
<style>
#avatar-crop-pane { 
    width: <?php echo BCP_MAX_WIDTH; ?>px;
    height: <?php echo BCP_MAX_HEIGHT; ?>px;
    overflow: hidden;
}
#avatar-crop-pane img{
    max-width: none;
}
                
.jcrop-holder{
    margin: 0 20px 20px 0;
}
</style>

<p>
    <?php
        echo sprintf(
            __('Select an image from your computer to upload or change your cover photo. 
                The image must be larger than %spx in width and %spx in height (%sx%s pixels) 
                to attain quality cover photo.', 'gears')
            , BCP_MAX_WIDTH, BCP_MAX_HEIGHT, BCP_MAX_WIDTH, BCP_MAX_HEIGHT
            );
    ?>
</p>
<p>
    <?php _e('Click below to select a JPG, GIF or PNG format photo from your computer and then click \'Upload Image\' to proceed.', 'gears'); ?>
</p>
           
<form action="" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">

    <?php if ( 'upload-image' == bp_get_avatar_admin_step() ) { ?>
        <?php wp_nonce_field('bp_avatar_upload'); ?>
        <p id="avatar-upload" class="break-row-top">
            <input class="break-row-bottom" type="file" name="file" id="file" />
            <input class="break-row-bottom" type="hidden" name="action" value="bp_avatar_upload" />
            <input class="break-row-bottom mg-top-35" type="submit" name="upload_cover_photo" 
                id="upload_cover_photo"  value="<?php _e( 'Upload Image', 'gears' ); ?>" />
        </p>
        <?php } else { 
            require_once 'cover-photo-crop.php';
        } ?>
</form>
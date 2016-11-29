<?php
/*
 * Cover Photo crop template
 *
 * @package bp-cover-photo
 * @since 2.0
 */
?>
<!--avatar to crop image -->
<div  id="avatar-to-crop-wrap">
    <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" 
        class="avatar" alt="<?php _e( 'Avatar to crop', 'gears' ); ?>" />
</div>
<!--end avatar to crop image-->

<!--avatar crop preview-->

    <input type="hidden" name="image_src" id="image_src" value="<?php echo bp_avatar_to_crop_src(); ?>" />
    <input type="hidden" id="x" name="x" />
    <input type="hidden" id="y" name="y" />
    <input type="hidden" id="x2" name="x2" />
    <input type="hidden" id="y2" name="y2" />
    <input type="hidden" id="w" name="w" />
    <input type="hidden" id="h" name="h" />
    <?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

<!--end avatar crop preview-->
<?php if (current_user_can('manage_options')) { ?>
<div id="admin-only-bcp-cover-photo-settings" class="alert alert-info">
    <label for="global-coverphoto">
        <?php
            if (bp_is_group()) {
                $type = 'group';
            } else {
                $type = 'user';
            }
        ?>
        <input type="checkbox" id="global-coverphoto" name="global-coverphoto" value="<?php echo $type; ?>"/>
        <span class="small">
                <?php _e('Make this image the default cover photo for new users and users who are yet to upload a cover photo.', 'gears'); ?>
        </span>
    </label>
</div>
<?php } ?>
<div class="break-row-top">
    <input type="submit" id="crop" name="avatar-crop-submit" value="<?php _e( 'Crop Image', 'gears' ); ?>" />
</div>

<script>
jQuery(function($) {


    var $avatarToCrop = $('#avatar-to-crop');

        imagesLoaded ($avatarToCrop, function()
        {
            var img_width = <?php echo BCP_MAX_WIDTH; ?>;
            var img_height = <?php echo BCP_MAX_HEIGHT; ?>;
            var imgNaturalWidth = document.querySelector('#avatar-to-crop').naturalWidth;
            var imgNaturalHeight = document.querySelector('#avatar-to-crop').naturalHeight;

                $avatarToCrop.Jcrop({
                    setSelect:   [ 0, 0, img_width, img_height ],
                    aspectRatio: 2.53/1,
                    trueSize: [imgNaturalWidth, imgNaturalHeight],
                    boxWidth: img_width,
                    boxHeight: img_height,
                    bgColor:'#fff',
                    onChange: bp_cover_photo_preview,
                    onSelect: bp_cover_photo_preview
                });

            return;
        }); 
 
                    
    function bp_cover_photo_preview(coords) 
    {
        	
         $('#x').val(coords.x);
         $('#y').val(coords.y);
         $('#x2').val(coords.x2);
         $('#y2').val(coords.y2);
         $('#w').val(coords.w);
         $('#h').val(coords.h);

         return;
    }
});
</script>
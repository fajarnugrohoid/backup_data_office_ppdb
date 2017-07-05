<?php
$note = '';
if (!empty($id)) {
    $note = get_post_field('post_content', $id);

    $note_title = array(
        '<',
        '>',
        'div class="stm-car-listing-data-single stm-border-top-unit"',
        'div class="title heading-font"',
        esc_html__('Seller Note', 'motors'),
        '/div',
    );

    $post_data['post_content'] = '<div class="stm-car-listing-data-single stm-border-top-unit">';
    $post_data['post_content'] .= '<div class="title heading-font">' . esc_html__('Seller Note', 'motors') . '</div></div>';

    $note = str_replace($note_title, '', $note);

}
?>

<div class="stm-form-5-notes clearfix">
    <div class="stm-car-listing-data-single stm-border-top-unit ">
        <div class="title heading-font"><?php esc_html_e('Enter Seller\'s notes', 'motors'); ?></div>
        <span class="step_number step_number_5 heading-font"><?php esc_html_e('step', 'motors'); ?> 5</span>
    </div>
    <div class="row stm-relative">
        <div class="col-md-9 col-sm-9 stm-non-relative">
            <div class="stm-phrases-unit">
                <?php if (!empty($stm_phrases)): $stm_phrases = explode(',', $stm_phrases); ?>
                    <div class="stm_phrases">
                        <div class="inner">
                            <i class="fa fa-close"></i>
                            <h5><?php esc_html_e('Select all the phrases that apply to your vehicle.', 'motors'); ?></h5>
                            <?php if (!empty($stm_phrases)): ?>
                                <div class="clearfix">
                                    <?php foreach ($stm_phrases as $phrase): ?>
                                        <label>
                                            <input type="checkbox" name="stm_phrase"
                                                   value="<?php echo esc_attr($phrase); ?>"/>
                                            <span><?php echo esc_attr($phrase); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                                <a href="#" class="button"><?php esc_html_e('Apply', 'motors'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <textarea placeholder="<?php esc_html_e('Enter Seller\'s notes', 'motors'); ?>"
                          name="stm_seller_notes"><?php echo esc_attr($note); ?></textarea>
            </div>
        </div>
        <?php if (!empty($stm_phrases)): ?>
            <div class="col-md-3 col-sm-3 hidden-xs">

                <div class="stm-seller-notes-phrases heading-font">
                    <span><?php esc_html_e('Add the Template Phrases', 'motors'); ?></span></div>

            </div>
        <?php endif; ?>
    </div>
</div>
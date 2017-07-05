<div class="stm-form-checking-user">
    <div class="stm-form-inner">
        <i class="stm-icon-load1"></i>
        <?php $restricted = false; ?>
        <?php if (is_user_logged_in()):
            $disabled = 'enabled';
            ?>
            <div id="stm_user_info">
                <?php stm_add_a_car_user_info('', '', ''); ?>
            </div>
        <?php else:
            $disabled = 'disabled'; ?>
            <div id="stm_user_info" style="display:none;"></div>
            <?php
        endif; ?>

        <div class="stm-not-<?php echo $disabled; ?>">
            <?php stm_add_a_car_registration($stm_title_user, $stm_text_user, $link); ?>
            <div class="stm-add-a-car-login-overlay"></div>
            <div class="stm-add-a-car-login">
                <div class="stm-login-form">
                    <form method="post">
                        <input type="hidden" name="redirect" value="disable">
                        <div class="form-group">
                            <h4><?php esc_html_e('Login or E-mail', 'motors'); ?></h4>
                            <input type="text" name="stm_user_login"
                                   placeholder="<?php esc_html_e('Enter login or E-mail', 'motors'); ?>">
                        </div>

                        <div class="form-group">
                            <h4><?php esc_html_e('Password', 'motors'); ?></h4>
                            <input type="password" name="stm_user_password"
                                   placeholder="<?php esc_html_e('Enter password', 'motors'); ?>">
                        </div>

                        <div class="form-group form-checker">
                            <label>
                                <input type="checkbox" name="stm_remember_me">
                                <span><?php esc_html_e('Remember me', 'motors'); ?></span>
                            </label>
                        </div>
                        <input type="submit" value="Login">
                        <span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
                        <div class="stm-validation-message"></div>
                    </form>
                </div>
            </div>
        </div>

        <button type="submit" class="<?php echo esc_attr($disabled); ?>">
            <?php if(!empty($id)): ?>
                <i class="stm-service-icon-add_check"></i><?php esc_html_e('Edit Ads', 'motors'); ?>
            <?php else: ?>
                <i class="stm-service-icon-add_check"></i><?php esc_html_e('Submit listing', 'motors'); ?>
            <?php endif; ?>
        </button>
        <span class="stm-add-a-car-loader"><i class="stm-icon-load1"></i></span>

        <div class="stm-add-a-car-message heading-font"></div>
    </div>
</div>
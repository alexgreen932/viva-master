<?php

//namespace SilkyDrum\WooCommerce;
class LoyaltyProgramInfoShortcode extends LoyaltyProgramService
{

    public function __construct()
    {
        add_action('init', [$this, 'register_shortcodes']);

    }

    public function register_shortcodes()
    {
        add_shortcode('lp_info_shortcode', [$this, 'lp_info']);
    }

    public function get_data()
    {
        //get current user
        $user_id = get_current_user_id();
        $this->loyalty_data = $this->get_loyalty_data($user_id);
    }
    public function lp_info()
    {

        $loyalty_data = $this->get_data();

        dd($loyalty_data);

        // Check if loyalty data is available, return if not
        if (!$loyalty_data) {
            echo '!!! No loyalty data available. Please update your profile.';
            return;
        }
        $level = $loyalty_data['loyalty_level'];
        $next_level = $loyalty_data['next_level'];
        $discounts = $loyalty_data['discounts'];
        $progress = $loyalty_data['progress'];

        // dd($loyalty_data);
        ob_start();
        //dev
        ?>


        <div class="loyalty_levels-item current">
            <div class="loyalty_levels-item__num"><?php echo esc_html($level); ?></div>

            <div class="loyalty_levels-item__content accordion">
                <div class="accordion-link">
                    <div class="loyalty_levels-item__title">
                        <?php printf(__('Вы на %d-м уровне в системе лояльности', 'lp-textdomain'), esc_html($level)); ?>
                    </div>
                    <div class="accordion-link__arrow">
                        <svg width="24" height="24">
                            <use xlink:href="<?php echo esc_url(DIST_URI . '/images/sprite/svg-sprite.svg#arrow'); ?>">
                            </use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //if level more than 0 do discounts
        if ( $level > 0) {
            $this->do_discounts();
        }
        //if level less than 3 do next level
        if ( $level < 3) {
            $this->do_next_level();
        }
        //close ob_start
        ob_end_clean();
        return ob_get_clean();
        ?>

        <?php if ($level < 3): ?>
            <div class="loyalty_levels-item">
                <div class="loyalty_levels-item__num"><?php echo esc_html($next_level); ?></div>
                <div class="loyalty_levels-item__content">
                    <div class="loyalty_levels-item__text">

                        <?php printf(__('До перехода на %1$d-й уровень осталось %2$d месяцев и %3$d заказов', 'lp-textdomain'), esc_html($next_level), esc_html($progress['months_left']), esc_html($progress['orders_needed'])); ?>


                    </div>
                    <div class="loyalty_levels-item__arrow"></div>
                </div>
            </div>
        <?php endif; ?>
        <?php
        return ob_get_clean();
    }

    public function do_discounts()
    {
        ?>
        <div class="accordion-panel">
            <div class="loyalty_levels-more accordion-panel__inner">
                <div class="loyalty_levels-more__list">
                    <?php if (!empty($discounts['espresso'])): ?>
                        <div class="loyalty_levels-more__item">
                            <div class="loyalty_levels-more__title">
                                <svg class="loyalty_levels-more__percent" width="16" height="16">
                                    <use xlink:href="<?php echo esc_url(DIST_URI . '/images/sprite/svg-sprite.svg#percent'); ?>">
                                    </use>
                                </svg>
                                <span><?php _e('Your discount on espresso', 'lp-textdomain'); ?></span>
                            </div>
                            <div class="loyalty_levels-more__values">
                                <?php echo '- ' . esc_html($discounts['espresso']['200g']) . ' ₽ per 200 g'; ?><br>
                                <?php echo '- ' . esc_html($discounts['espresso']['1kg']) . ' ₽ per 1 kg'; ?>
                            </div>
                        </div>
                        <!-- <?php endif; ?> -->

                    <?php if (!empty($discounts['filter'])): ?>
                        <div class="loyalty_levels-more__item">
                            <div class="loyalty_levels-more__title">
                                <svg class="loyalty_levels-more__percent" width="16" height="16">
                                    <use xlink:href="<?php echo esc_url(DIST_URI . '/images/sprite/svg-sprite.svg#percent'); ?>">
                                    </use>
                                </svg>
                                <span><?php _e('Your filter discount', 'lp-textdomain'); ?></span>
                            </div>
                            <div class="loyalty_levels-more__values">
                                <?php echo '- ' . esc_html($discounts['filter']['200g']) . ' ₽ from 200 g'; ?><br>
                                <?php echo '- ' . esc_html($discounts['filter']['1kg']) . ' ₽ from 1 kg'; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="loyalty_levels-more__link modal-trigger" data-modal="loyalty_info">
                    <?php _e('More details', 'lp-textdomain'); ?>
                </div>
            </div>
        </div>

        <?php

    }
}


<template>
    <div class="cookies-banner">
        <div class="container">
            <div class="cookies-banner__control">
                <button type="button" :aria-label="__('close')" class="btn cookies-banner-btn" @click="close">
                <span aria-hidden="true" class="btn__icon">
                    <svg role="img" aria-hidden="true" width="26" height="26">
                        <use xlink:href="#svg-icon-cancel"></use>
                    </svg>
                </span>
                </button>
            </div>
            <div class="cookies-banner__text">
                {{ __('cookie_banner') }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            close() {
                $('.cookies-banner').hide();
            }
        }
    }
</script>

<template>
    <div>
        <div v-if="checkUserDevice === 'iOS'">
            <a rel="ar" href="/public/images/chair_swan.usdz">
                <img alt="3d" src="/public/images/3d_icon.png"/>
            </a>
        </div>
        <div v-else-if="checkUserDevice === 'Android'">
            <a href="intent://arvr.google.com/scene-viewer/1.0?file=https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Models/master/2.0/Avocado/glTF/Avocado.gltf#Intent;scheme=https;package=com.google.android.googlequicksearchbox;action=android.intent.action.VIEW;S.browser_fallback_url=https://developers.google.com/ar;end;">Avocado</a>
        </div>
        <div v-else>UNKNOWN</div>
    </div>
</template>

<script>
    export default {
        computed: {
            checkUserDevice() {
                let userAgent = navigator.userAgent || navigator.vendor || window.opera;

                // Windows Phone must come first because its UA also contains "Android"
                if (/windows phone/i.test(userAgent)) {
                    return "Windows Phone";
                }

                if (/android/i.test(userAgent)) {
                    return "Android";
                }

                // iOS detection from: http://stackoverflow.com/a/9039885/177710
                if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                    return "iOS";
                }

                return "unknown";
            }
        }
    }
</script>

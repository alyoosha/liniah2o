<h4 class="ml-8 mb-4 text-xs text-white-50% uppercase tracking-wide">Слайдеры</h4>
<router-link
    tag="h3"
    :to="{
            name: 'index',
            params: {
                resourceName: 'promo-sliders',
            }
        }"
    class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline">

    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path fill="var(--sidebar-icon)" d="M21.499 15c-.209 0-.419-.065-.599-.2-.442-.331-.532-.958-.2-1.4l1.05-1.4-1.05-1.4c-.332-.442-.242-1.069.2-1.4.441-.333 1.067-.242 1.399.2l1.5 2c.267.355.267.845 0 1.2l-1.5 2c-.195.262-.495.4-.8.4zM2.501 15c-.305 0-.604-.138-.801-.4l-1.5-2c-.267-.355-.267-.845 0-1.2l1.5-2c.331-.441.958-.532 1.4-.2.442.331.532.958.2 1.4l-1.05 1.4 1.05 1.4c.332.442.242 1.069-.2 1.4-.18.135-.39.2-.599.2zM16 22h-8c-1.654 0-3-1.346-3-3v-14c0-1.654 1.346-3 3-3h8c1.654 0 3 1.346 3 3v14c0 1.654-1.346 3-3 3zm-8-18c-.552 0-1 .449-1 1v14c0 .551.448 1 1 1h8c.552 0 1-.449 1-1v-14c0-.551-.448-1-1-1z"/>
    </svg>

    <span class="sidebar-label">
        Промо-слайдер
    </span>
</router-link>
<router-link
    tag="h3"
    :to="{
            name: 'index',
            params: {
                resourceName: 'catalog-sliders',
            }
        }"
    class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline">
    <svg class="sidebar-icon svg-inline--fa fa-clipboard-list fa-w-12" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clipboard-list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="var(--sidebar-icon)" d="M336 64h-80c0-35.3-28.7-64-64-64s-64 28.7-64 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM96 424c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm0-96c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm0-96c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm96-192c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm128 368c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-96c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-96c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16z"></path></svg>
    <span class="sidebar-label">
        Каталог-слайдер
    </span>
</router-link>

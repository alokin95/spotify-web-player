<template>
    <section class="accordion">
        <section class="accordion-tabs">
            <button class="accordion-tab accordion-active" data-actab-group="0" data-actab-id="0" @click="selectTab('spotify')">Spotify</button>
            <button class="accordion-tab" data-actab-group="0" data-actab-id="1" @click="selectTab('sports')">Sports</button>
        </section>
        <section class="accordion-content">
            <article class="accordion-item accordion-active" data-actab-group="0" data-actab-id="0">
                <div class="accordion-item__container">
                    <spotify-settings v-if="selectedTab === 'spotify'"></spotify-settings>
                </div>
            </article>
            <article class="accordion-item" data-actab-group="0" data-actab-id="1">
                <div class="accordion-item__container">

                </div>
            </article>
        </section>
    </section>

</template>

<script>

import SpotifySettings from './SpotifySettingsComponent';

export default {
    data() {
      return {
          selectedTab: "spotify"
      }
    },

    mounted() {
        this.initializeTabs();
    },

    components: {
        SpotifySettings
    },

    methods: {

        selectTab(tab) {
            this.selectedTab = tab;
        },

        initializeTabs(){
            const labels = document.querySelectorAll(".accordion-item__label");
            const tabs = document.querySelectorAll(".accordion-tab");

            function toggleShow() {
                const target = this;
                const item = target.classList.contains("accordion-tab")
                    ? target
                    : target.parentElement;
                const group = item.dataset.actabGroup;
                const id = item.dataset.actabId;

                tabs.forEach(function(tab) {
                    if (tab.dataset.actabGroup === group) {
                        if (tab.dataset.actabId === id) {
                            tab.classList.add("accordion-active");
                        } else {
                            tab.classList.remove("accordion-active");
                        }
                    }
                });

                labels.forEach(function(label) {
                    const tabItem = label.parentElement;

                    if (tabItem.dataset.actabGroup === group) {
                        if (tabItem.dataset.actabId === id) {
                            tabItem.classList.add("accordion-active");
                        } else {
                            tabItem.classList.remove("accordion-active");
                        }
                    }
                });
            }

            labels.forEach(function(label) {
                label.addEventListener("click", toggleShow);
            });

            tabs.forEach(function(tab) {
                tab.addEventListener("click", toggleShow);
            });

        }
    }
}
</script>

<style scoped>

.accordion {
    background: #f9f9f9;
}
.accordion-tabs {
    display: none;
}
.accordion-tabs :focus {
    outline: none;
}
.accordion-item {
    border-bottom: 1px solid #eaeaea;
}
.accordion-item:last-child {
    border: none;
}
.accordion-item__label {
    margin: 0;
    padding: 1.25rem;
    cursor: pointer;
    -webkit-transition: padding .2s ease;
    transition: padding .2s ease;
    position: relative;
}
.accordion-item__label:after {
    content: "";
    height: 4px;
    width: 4px;
    position: absolute;
    top: -4px;
    right: 1.25rem;
    bottom: 0;
    margin: auto;
    border: 3px solid transparent;
    border-radius: 2px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    border-color: transparent #447fff #447fff transparent;
    opacity: 1;
    -webkit-transition: opacity .1s ease;
    transition: opacity .1s ease;
}
.accordion-item__label:hover {
    background: #d3e1ff;
}
.accordion-item__container {
    padding: 0 1.25em;
    height: 0;
    overflow: hidden;
    opacity: 0;
    -webkit-transition: padding .2s ease, opacity .5s .15s ease;
    transition: padding .2s ease, opacity .5s .15s ease;
}
.accordion-active {
    background: rgba(68, 127, 255, 0.1);
}
.accordion-active .accordion-item__label {
    padding-bottom: 0;
    cursor: inherit;
}
.accordion-active .accordion-item__label:hover {
    background: none;
}
.accordion-active .accordion-item__label:after {
    opacity: 0;
}
.accordion-active .accordion-item__container {
    padding: 1.25em;
    height: auto;
    opacity: 1;
}
.accordion-active .accordion-item__container p:first-child, .accordion-active .accordion-item__container h1:first-child, .accordion-active .accordion-item__container h2:first-child, .accordion-active .accordion-item__container h3:first-child, .accordion-active .accordion-item__container h4:first-child, .accordion-active .accordion-item__container h5:first-child, .accordion-active .accordion-item__container h6:first-child {
    margin-top: 0;
}
.accordion-active .accordion-item__container p:last-child, .accordion-active .accordion-item__container h1:last-child, .accordion-active .accordion-item__container h2:last-child, .accordion-active .accordion-item__container h3:last-child, .accordion-active .accordion-item__container h4:last-child, .accordion-active .accordion-item__container h5:last-child, .accordion-active .accordion-item__container h6:last-child {
    margin-bottom: 0;
}

@media (min-width: 600px) {
    .accordion-tabs {
        display: -webkit-box;
        display: flex;
        background: rgba(68, 127, 255, 0.1);
    }
    .accordion-tabs .accordion-tab {
        background: rgba(68, 127, 255, 0.1);
        padding: 1rem 2rem;
        font: inherit;
        -webkit-box-flex: 1;
        flex: 1;
        border: none;
        cursor: pointer;
        -webkit-transition: background .1s ease;
        transition: background .1s ease;
    }
    .accordion-tabs .accordion-tab:hover {
        background: rgba(249, 249, 249, 0.01);
    }
    .accordion-tabs .accordion-tab:last-child {
        border-right: 0;
    }
    .accordion-tabs .accordion-tab.accordion-active {
        background: #f9f9f9;
    }

    .accordion-item {
        padding: 2.4rem;
        display: none;
        border: none;
        background: #f9f9f9;
        min-height: 260px;
    }
    .accordion-item__label, .accordion-item__container {
        padding: 0;
        -webkit-transition: inherit;
        transition: inherit;
    }
    .accordion-item__label {
        margin-bottom: 1.5rem;
    }
    .accordion-item.accordion-active {
        display: block;
    }
    .accordion-item.accordion-active .accordion-item__container {
        padding: 0;
    }
}
* {
    box-sizing: border-box;
}

.accordion {
    box-shadow: 0 1em 2em -0.9em rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
    max-width: 400px;
}
@media (min-width: 600px) {
    .accordion {
        max-width: 600px;
    }
}
.accordion + p {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 300;
    font-size: .9rem;
    margin-top: 2rem;
}

body {
    background: #3b70fc;
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    font-size: 1rem;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    height: 100vh;
}

</style>

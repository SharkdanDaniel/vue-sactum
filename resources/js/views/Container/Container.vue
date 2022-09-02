<template>
  <div class="full-height">
    <q-layout view="hHh Lpr lff" container class="shadow-2 full-height">
    
    <Navbar @onMenuClicked="drawer = !drawer" />

      <q-drawer
        v-model="drawer"
        show-if-above
        :mini="!drawer || miniState"
        @click.capture="drawerClick"
        :width="200"
        :breakpoint="500"
        bordered
        class="bg-grey-6"
      >
        <template v-slot:mini>
          <q-scroll-area class="fit mini-slot cursor-pointer">
            <div class="q-py-lg">
              <div class="column items-center">
                <q-icon name="fa-solid fa-house" class="mini-icon" />
                <q-icon name="fa-solid fa-users" class="mini-icon" />
                <q-icon name="fa-solid fa-box-open" class="mini-icon" />
              </div>
            </div>
          </q-scroll-area>
        </template>

        <q-scroll-area class="fit">
          <q-list padding>
            <q-item clickable v-ripple>
              <q-item-section>
                <router-link active-class="active" to="/home">Home</router-link>
              </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section>
                <router-link active-class="active" to="/users">Usuários</router-link>
              </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section>
                <router-link active-class="active" to="/products">Produtos</router-link>
              </q-item-section>
            </q-item>
          </q-list>
        </q-scroll-area>
        <div
          class="q-mini-drawer-hide absolute"
          style="top: 15px; right: -17px"
        >
          <q-btn
            dense
            round
            unelevated
            color="primary"
            icon="fa-solid fa-chevron-left"
            @click="miniState = true"
          />
        </div>
      </q-drawer>

      <q-page-container>
        <q-page class="container">
          <router-view></router-view>
        </q-page>
      </q-page-container>
    </q-layout>
  </div>
</template>

<script lang="ts">
import { useQuasar } from "quasar";
import { computed, defineComponent, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { getUsers } from "../../services/userService";
import Navbar from "../../components/Navbar.vue";

export default defineComponent({
    name: "ContainerView",
    setup() {
        const miniState = ref(true);
        return {
            drawer: ref(false),
            miniState,
            drawerClick(e: Event) {
                if (miniState.value) {
                    miniState.value = false;
                    e.stopPropagation();
                }
            },
        };
    },
    components: { Navbar }
});
</script>

<style lang="scss">
.active {
    color: $primary;
    font-weight: 700;
}
.mini-slot {
  transition: background-color 0.28s;

  &:hover {
    background-color: rgba(0, 0, 0, 0.04);
  }
}

.mini-icon {
  font-size: 1.718em;

  & + & {
    margin-top: 18px;
  }
}
</style>

<template>
  <div id="app">
    <div id="nav" style="margin: 0 auto;text-align: center" v-if="isShow">
      <router-link to="/">产品</router-link> |
      <router-link to="/Coupon">优惠券</router-link>
    </div>
    <router-view/>
  </div>
</template>

<script>

export default {
  name: 'coupon',
  data() {
    return {
      isShow: true
    }
  },
  methods: {
    
  },
  watch: {
    $route(to) {
      console.log(to)
      if(to.path == '/Login') {
        this.isShow = false
      }
      else {
        this.isShow = true
      }
    }
  }

}

</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>

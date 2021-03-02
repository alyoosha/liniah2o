Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'promo-slider-tool',
      path: '/promo-slider-tool',
      component: require('./components/Tool'),
    },
  ])
})

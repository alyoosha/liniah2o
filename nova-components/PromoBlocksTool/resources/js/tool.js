Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'promo-blocks-tool',
      path: '/promo-blocks-tool',
      component: require('./components/Tool'),
    },
  ])
})

Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'catalog-slider-tool',
      path: '/catalog-slider-tool',
      component: require('./components/Tool'),
    },
  ])
})

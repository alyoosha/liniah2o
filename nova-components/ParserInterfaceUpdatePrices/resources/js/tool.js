Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'parser-interface-update-prices',
      path: '/parser-interface-update-prices',
      component: require('./components/Tool'),
    },
  ])
})

Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'parser-interface',
      path: '/parser-interface',
      component: require('./components/Tool'),
    },
  ])
})

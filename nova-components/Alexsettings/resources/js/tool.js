Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'alexsettings',
      path: '/alexsettings',
      component: require('./components/Tool'),
    },
  ])
})

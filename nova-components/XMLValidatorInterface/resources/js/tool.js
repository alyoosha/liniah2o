Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'XMLValidatorInterface',
      path: '/XMLValidatorInterface',
      component: require('./components/Tool'),
    },
  ])
})

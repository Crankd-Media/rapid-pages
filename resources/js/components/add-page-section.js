export default (initIndex = null) => ({
  index: initIndex,
  position: "before",
  init() {},
  setUpSections(event) {
    this.index = event.index;
    this.position = event.position;
  },
});

export default (intPage, initItems = null, initSections = null, intRoute) => ({
  page: intPage,
  items: initItems,
  sections: initSections,
  route: intRoute,
  eventListeners: {
    ["@settings-updated.window"](event) {
      console.log(event.detail);
    },
  },
  init() {
    console.log(this.items);
    console.log(this.sections);
  },
  remove(index) {
    this.items.splice(index, 1);
  },
  addSection(data) {
    console.log(data);
    const index = data.index;
    const position = data.position;
    const section = data.section;

    console.log(section);

    if (position == "before") {
      this.items.splice(index, 0, section);
    } else {
      this.items.splice(index + 1, 0, section);
    }
  },
  moveUp(index) {
    if (index > 0) {
      const item = this.items[index];
      this.items.splice(index, 1);
      this.items.splice(index - 1, 0, item);
    }
  },
  moveDown(index) {
    if (index < this.items.length - 1) {
      const item = this.items[index];
      this.items.splice(index, 1);
      this.items.splice(index + 1, 0, item);
    }
  },
  duplicate(index) {
    const item = JSON.parse(JSON.stringify(this.items[index]));
    item.pivot = null;
    this.items.splice(index + 1, 0, item);
    // this.items.splice(index, 0, item);
  },
  async updatePage() {
    console.log("updatePage");
    console.log(this.page);
    console.log(this.items);
    console.log(this.route);

    const response = await axios.patch(this.route, {
      page_id: this.page,
      sections: this.items,
    });
  },
  discardChangers() {
    this.items = this.page.sections;
  },
});

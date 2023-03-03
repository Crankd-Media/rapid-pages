export default (initSection = null) => ({
  section: initSection,
  section_fields: {},
  init() {
    this.$watch("section", (value) => {
      this.setSettings();
    });
  },
  setSettings() {
    // this.settings = this.section.fieldValues;
    this.section_fields = this.section.fieldValues;
  },
  async updateSectionSettings() {
    // if (this.section.pivot) {
    //   const response = await axios.put(
    //     `/section-settings/${this.section.pivot.section_settings_id}`,
    //     {
    //       settings: this.settings,
    //     }
    //   );
    // }
  },
  discardChanges() {
    this.setSettings();
  },
});

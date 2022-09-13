<template>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a
            class="nav-link active"
            aria-current="true"
            data-bs-toggle="tab"
            data-bs-target="#write-tab-pane"
            href="#write-tab-pane"
            >Write</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#preview-tab-pane"
            href="preview-tab-pane"
            >Preview</a
          >
        </li>
      </ul>
    </div>
    <div class="card-body tab-content">
      <!-- slot is like placeholder in vue js. This will be replaced by data from parent component.In this case we will eplace it with text area -->
      <div class="tab-pane active" role="tabpanel" id="write-tab-pane">
        <slot></slot>
      </div>
      <div
        class="tab-pane"
        role="tabpanel"
        id="preview-tab-pane"
        v-html="preview"
      ></div>
    </div>
  </div>
</template>
<script>
import MarkdownIt from "markdown-it";
const md = new MarkdownIt();
export default {
  props: ["body"],

  computed: {
    preview() {
      return md.render(this.body);
    },
  },
};
</script>
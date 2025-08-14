// entry point
// include your assets here

// get styles
import.meta.glob("./css/**/*.css", { eager: true });

// get scripts
import "./js/app.js";

// get images
import.meta.glob(["./images/**"]);

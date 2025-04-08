import { viewportFix, viewportSize } from "./utility/viewport";

/**
 * viewportに関する処理
 */
window.addEventListener("load", () => {
  viewportSize();
  viewportFix();
});

window.addEventListener("resize", () => {
  viewportSize();
  viewportFix();
});

/**
 * modules
 */

// toaster.js

(function () {
  // If already initialized, skip (avoid duplicate listeners and redeclarations)
  if (window.Toast) return;

  const Toast = class {
    static show(message, type = "info", options = {}) {
      if (!message) return;

      const toastData = {
        type: type,
        message: message,
        duration: options.duration ?? 5000,
        showProgress: options.showProgress ?? false,
        ...options,
      };

      console.log(toastData);

      window.dispatchEvent(
        new CustomEvent("toast", {
          detail: toastData,
          bubbles: true,
        })
      );
    }

    static success(message, options = {}) {
      this.show(message, "success", options);
    }

    static error(message, options = {}) {
      const defaultOptions = { duration: 8000 };
      this.show(message, "error", { ...defaultOptions, ...options });
    }

    static warning(message, options = {}) {
      const defaultOptions = { duration: 6000 };
      this.show(message, "warning", { ...defaultOptions, ...options });
    }

    static info(message, options = {}) {
      this.show(message, "info", options);
    }

    static loading(message = "Loading...", options = {}) {
      const defaultOptions = { duration: 0 };
      return this.show(message, "loading", { ...defaultOptions, ...options });
    }

    static clear() {
      window.dispatchEvent(new CustomEvent("toast-clear", { bubbles: true }));
    }

    static fromFlash(flashData) {
      if (!flashData || !flashData.type || !flashData.message) return;
      this.show(flashData.message, flashData.type, flashData.options || {});
    }

    static fromValidationErrors(errors) {
      if (Array.isArray(errors)) {
        errors.forEach((error) => this.error(error));
      } else if (typeof errors === "object") {
        Object.values(errors).forEach((errorArray) => {
          if (Array.isArray(errorArray)) {
            errorArray.forEach((error) => this.error(error));
          } else {
            this.error(errorArray);
          }
        });
      }
    }

    static async promise(promise, messages = {}) {
      this.loading(messages.loading || "Processing...");

      try {
        const result = await promise;
        this.clear();
        this.success(messages.success || "Operation completed!");
        return result;
      } catch (error) {
        this.clear();
        this.error(messages.error || error.message || "Operation failed");
        throw error;
      }
    }
  };

  // Attach to global
  window.Toast = Toast;

  // Auto-init once
  const initFromLaravel = () => {
    if (window.Laravel && window.Laravel.toast) {
      window.Toast.fromFlash(window.Laravel.toast);
    }

    if (window.Laravel && window.Laravel.errors) {
      window.Toast.fromValidationErrors(window.Laravel.errors);
    }
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initFromLaravel);
  } else {
    initFromLaravel();
  }

  // Re-init if Livewire navigation happens (SPA)
  document.addEventListener("livewire:navigated", initFromLaravel);
})();

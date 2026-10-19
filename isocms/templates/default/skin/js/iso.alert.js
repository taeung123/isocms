// khai báo theme chung
const isoSwal = Swal.mixin({
    buttonsStyling: false,
    reverseButtons: true,
    allowOutsideClick: false,
    customClass: {
        popup: 'iso-alert',
        title: 'iso-alert-title',
        htmlContainer: 'iso-alert-content',
        actions: 'iso-alert-actions',
        confirmButton: 'iso-btn iso-btn-primary',
        cancelButton: 'iso-btn iso-btn-secondary'
    }
});


const AlertTemplate = {
    render(name, data = {}) {
        const template = document.getElementById(`alert-layout-${name}`);
        if (!template) {
            console.error(`Alert template "${name}" not found`);
            return "";
        }
        let html = template.innerHTML;
        Object.keys(data).forEach(key => {
            const value = data[key] ?? "";
            html = html.replaceAll(`[[${key}]]`, value);
        });
        // Xóa các placeholder chưa được truyền
        html = html.replace(/\[\[\w+\]\]/g, "");
        return html;
    }
};

// khai báo layout (default, modern, ...)
const AlertLayouts = {
    // default: layoutDefault,
    // modern: layoutModern
    default(options) {
        return {
            html: AlertTemplate.render("default", options)
        };
    },

    modern(options) {
        return {
            html: AlertTemplate.render("modern", options)
        };
    }

};

function layoutDefault(options) {
    return {
        html: AlertTemplate.render("default", {
            title: options.title,
            message: options.message,
            icon: ""
        })
    };

}

function layoutModern(options) {
    let content = "";
    // Nếu dùng input của SweetAlert
    if (options.input) {
        content = `
            <div class="iso-modern-question">
                ${options.question ?? ""}
            </div>
        `;
    }
    return {
        html: AlertTemplate.render("modern", {
            icon: AlertIcons[options.type] ?? "",
            title: options.title,
            message: options.message,
            content: content,
            footer: options.footer ?? ""
        })
    };
}



const Alert = {
    show(options = {}) {
        const defaults = {
            type: "info",
            layout: "default",
            title: "",
            message: ""
        };
        options = {
            ...defaults,
            ...options
        };
        const layout = AlertLayouts[options.layout](options);
        const swalOptions = {
            ...options,
            ...layout,
            icon: options.type
        };

        delete swalOptions.type;
        delete swalOptions.layout;
        delete swalOptions.message;

        return isoSwal.fire(swalOptions);
    }
};


Alert.success = function (options = {}) {
    return this.show({
        type: "success",
        ...options
    });
};

Alert.error = function (options = {}) {
    return this.show({
        type: "error",
        ...options
    });
};

Alert.warning = function (options = {}) {
    return this.show({
        type: "warning",
        ...options
    });
};

Alert.info = function (options = {}) {
    return this.show({
        type: "info",
        ...options
    });
};

Alert.question = function (options = {}) {
    return this.show({
        type: "question",
        ...options
    });
};

Alert.loading = function (options = {}) {
    return this.show({
        title: "Loading...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
        ...options
    });
};

Alert.close = function () {
    Swal.close();
}

Alert.toast = function (options = {}) {
    return isoSwal.fire({
        toast: true,
        position: "top-end",
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        ...options
    });
};


Alert.toastError = function (title, options = {}) {
    return this.toast({
        icon: "error",
        title,
        ...options
    });
};

Alert.toastWarning = function (title, options = {}) {
    return this.toast({
        icon: "warning",
        title,
        ...options
    });
};

Alert.toastInfo = function (title, options = {}) {
    return this.toast({
        icon: "info",
        title,
        ...options
    });
};

console.log("iso.alert.js loaded");

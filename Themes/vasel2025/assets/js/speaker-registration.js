class FileUploader {
    constructor(inputSelector, nameSelector, defaultText) {
        this.input = document.querySelector(inputSelector);
        this.nameDisplay = document.querySelector(nameSelector);
        this.defaultText = defaultText;

        if (this.input) {
            this.input.addEventListener('change', this.updateFileName.bind(this));
        }
    }

    updateFileName() {
        this.nameDisplay.textContent = this.input.files.length > 0 ? this.input.files[0].name : this.defaultText;
    }
}

class ConferenceRegistration {
    constructor(config = {}) {
        this.config = Object.assign({
            paymentMethodSelector: 'input[name="payment_method"]',
            cashPaymentDescriptionSelector: ".cash_payment_description",
            wireTransferDescriptionSelector: ".wire_transfer_description",
            uncSectionSelector: "#unc_section",
            datepickerSelector: ".datepicker",
            radioButtonConfig: [
                { selector: 'input[name="title"]', matchValue: "other", targetSelector: "#titleOther" },
                { selector: 'input[name="session"]', matchValue: "other_session", targetSelector: "#sessionOther" },
                { selector: 'input[name="course"]', matchValue: "other_course", targetSelector: "#other_course" },
                { selector: 'input[name="training"]', matchValue: "yes", targetSelector: ".has_training", isBlock: true }
            ],
            fileUploadConfig: [
                { input: '#report_file_summary_input', name: '#report_file_summary_name', defaultText: 'FILE BÁO CÁO TÓM TẮT' },
                { input: '#report_file_full_input', name: '#report_file_full_name', defaultText: 'FILE BÁO CÁO TOÀN VĂN' },
                { input: '#shortCV_input', name: '#shortCV_name', defaultText: 'SHORT CV' },
                { input: '#passport_input', name: '#passport_name', defaultText: 'PASSPORT' },
                { input: '#UNC_input', name: '#UNC_name', defaultText: 'ĐÍNH KÈM SAO KÊ/ UNC NẾU ĐÃ CHUYỂN KHOẢN' }
            ],
            customTogglePaymentMethod: null
        }, config);

        this.initElements();
        this.bindEvents();
        this.initDatePicker();
        this.initFileUploaders();
    }

    initElements() {
        this.paymentMethods = document.querySelectorAll(this.config.paymentMethodSelector);
        this.cashPaymentDescription = document.querySelector(this.config.cashPaymentDescriptionSelector);
        this.wireTransferDescription = document.querySelector(this.config.wireTransferDescriptionSelector);
        this.uncSection = document.querySelector(this.config.uncSectionSelector);
    }

    bindEvents() {
        this.config.radioButtonConfig.forEach(config => {
            const elements = document.querySelectorAll(config.selector);
            const targetElement = document.querySelector(config.targetSelector);
            if (elements.length && targetElement) {
                this.bindRadioToggle(elements, config.matchValue, targetElement, config.isBlock || false);
            }
        });

        this.bindPaymentMethods();
    }

    bindPaymentMethods() {
        this.paymentMethods.forEach(item => {
            item.addEventListener("click", (e) => {
                if (this.config.customTogglePaymentMethod) {
                    this.config.customTogglePaymentMethod(e.target);

                } else {
                    this.togglePaymentMethod(e.target);

                }
            });
        })
    }

    togglePaymentMethod(target) {
        const isBankTransfer = target.value === "bank-transfer";
        this.wireTransferDescription.style.display = isBankTransfer ? "block" : "none";
        this.cashPaymentDescription.style.display = isBankTransfer ? "none" : "block";
    }

    bindRadioToggle(elements, matchValue, targetElement, isBlock = false) {
        elements.forEach(item => {
            item.addEventListener("click", (e) => {
                if (e.target.checked) {
                    targetElement.style.display = isBlock ? (e.target.value === matchValue ? 'block' : 'none') : '';
                    targetElement.disabled = e.target.value !== matchValue;
                }
            });
        });
    }

    initDatePicker() {
        flatpickr(this.config.datepickerSelector, {
            dateFormat: "d/m/Y"
        });
    }

    initFileUploaders() {
        this.fileUploaders = this.config.fileUploadConfig.map(config =>
            new FileUploader(config.input, config.name, config.defaultText)
        );
    }

    static uploadOtherCV() {
        document.querySelector("#uploadCV").style.display = "flex";
    }

    static uploadOtherPassport() {
        document.querySelector("#uploadPassport").style.display = "flex";
    }
}



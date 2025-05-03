import validationMessages from "@/Constants/validationMessages";

// 郵便番号のバリデーション 必須 / 7桁の数字
export const validatePostalcode = (form) => {
    if (!form.postalcode) {
        form.errors.postalcode = validationMessages.common.required;
    } else if (!/^\d{7}$/.test(form.postalcode)) {
        form.errors.postalcode = validationMessages.common.postalcode;
    } else {
        delete form.errors.postalcode;
    }
};

// Prefecture(都道府県名)のバリデーション 必須 / 10文字以内
export const validatePrefecture = (form) => {
    if (!form.prefecture) {
        form.errors.prefecture = validationMessages.common.required;
    } else if (form.prefecture.length > 10) {
        form.errors.prefecture = validationMessages.common.prefecture;
    } else {
        delete form.errors.prefecture;
    }
};

// City(市区町村名)のバリデーション 必須 / 30文字以内
export const validateCity = (form) => {
    if (!form.city) {
        form.errors.city = validationMessages.common.required;
    } else if (form.city.length > 30) {
        form.errors.city = validationMessages.common.city;
    } else {
        delete form.errors.city;
    }
};

// Address1(地域名)のバリデーション 必須 / 50文字以内
export const validateAddress1 = (form) => {
    if (!form.address1) {
        form.errors.address1 = validationMessages.common.required;
    } else if (form.address1.length > 50) {
        form.errors.address1 = validationMessages.common.address1;
    } else {
        delete form.errors.address1;
    }
};

// Address2(建物名)のバリデーション 必須 / 100文字以内
export const validateAddress2 = (form) => {
    if (!form.address2) {
        form.errors.address2 = validationMessages.common.required;
    } else if (form.address2.length > 100) {
        form.errors.address2 = validationMessages.common.address2;
    } else {
        delete form.errors.address2;
    }
};

// 電話番号のバリデーション 必須 / 数字のみ / 10桁または11桁
export const validatePhoneNumber = (form) => {
    if (!form.phone_number) {
        form.errors.phone_number = validationMessages.common.required;
    } else if (!/^\d+$/.test(form.phone_number)) {
        form.errors.phone_number = validationMessages.common.phone_number;
    } else if (
        form.phone_number.length !== 10 &&
        form.phone_number.length !== 11
    ) {
        form.errors.phone_number =
            validationMessages.common.phone_number_length;
    } else {
        delete form.errors.phone_number;
    }
};

export const validateAllFields = (form) => {
    validatePostalcode(form);
    validatePrefecture(form);
    validateCity(form);
    validateAddress1(form);
    validateAddress2(form);
    validatePhoneNumber(form);
};

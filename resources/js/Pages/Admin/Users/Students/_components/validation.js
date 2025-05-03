import validationMessages from "@/Constants/validationMessages";

// 姓のバリデーション 必須 / 40文字以内
export const validateLastName = (form) => {
    if (!form.last_name) {
        form.errors.lastname = validationMessages.common.required;
    } else if (form.lastname.length > 40) {
        form.errors.lastname = validationMessages.common.lastname;
    } else {
        delete form.errors.last_name;
    }
};

// 名のバリデーション 必須 / 40文字以内
export const validateFirstName = (form) => {
    if (!form.first_name) {
        form.errors.firstname = validationMessages.common.required;
    } else if (form.firstname.length > 40) {
        form.errors.firstname = validationMessages.common.firstname;
    } else {
        delete form.errors.first_name;
    }
};

// 姓(カナ)のバリデーション 必須 / 50文字以内
export const validateLastNameKana = (form) => {
    if (!form.last_name_kana) {
        form.errors.lastname_kana = validationMessages.common.required;
    } else if (form.lastname_kana.length > 50) {
        form.errors.lastname_kana = validationMessages.common.lastname_kana;
    } else {
        delete form.errors.last_name_kana;
    }
};

// 名(カナ)のバリデーション 必須 / 50文字以内
export const validateFirstNameKana = (form) => {
    if (!form.first_name_kana) {
        form.errors.firstname_kana = validationMessages.common.required;
    } else if (form.firstname_kana.length > 50) {
        form.errors.firstname_kana = validationMessages.common.firstname_kana;
    } else {
        delete form.errors.first_name_kana;
    }
};

// 生年月日のバリデーション 必須 / YYYY-MM-DD形式
export const validateBirthDate = (form) => {
    if (!form.birth_date) {
        form.errors.birth_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.birth_date)) {
        form.errors.birth_date = validationMessages.common.start_date;
    } else {
        delete form.errors.birth_date;
    }
};

// 性別のバリデーション 選択必須 / 男性、女性、その他のいずれか
export const validateGender = (form) => {
    //
}

// 携帯番号のバリデーション 必須 / 数字のみ / 10桁または11桁
export const validateMobileNumber = (form) => {
    if (!form.mobile_number) {
        form.errors.mobile_number = validationMessages.common.required;
    } else if (!/^\d+$/.test(form.mobile_number)) {
        form.errors.mobile_number = validationMessages.common.mobile_number;
    } else if (
        form.phone_mobile.length !== 10 &&
        form.phone_mobile.length !== 11
    ) {
        form.errors.mobile_number =
            validationMessages.common.mobile_number_length;
    } else {
        delete form.errors.mobile_number;
    }
};

// 緊急連絡先の関係性のバリデーション 必須 / 20文字以内
export const validateMobileNumberRelationship = (form) => {
    if (!form.mobile_number_relationship) {
        form.errors.mobile_number_relationship =
            validationMessages.common.required;
    } else if (form.mobile_number_relationship.length > 20) {
        form.errors.mobile_number_relationship =
            validationMessages.common.mobile_number_relationship;
    } else {
        delete form.errors.mobile_number_relationship;
    }
}

export const validateAllFields = (form) => {
    validatePostalcode(form);
    validatePrefecture(form);
    validateCity(form);
    validateAddress1(form);
    validateAddress2(form);
    validatePhoneNumber(form);
};

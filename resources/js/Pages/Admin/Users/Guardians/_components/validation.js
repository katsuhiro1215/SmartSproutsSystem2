import validationMessages from "@/Constants/validationMessages";

// 姓のバリデーション 必須 / 40文字以内
export const validateLastname = (form) => {
    if (!form.last_name) {
        form.errors.lastname = validationMessages.common.required;
    } else if (form.lastname.length > 40) {
        form.errors.lastname = validationMessages.common.lastname;
    } else {
        delete form.errors.last_name;
    }
};

// 名のバリデーション 必須 / 40文字以内
export const validateFirstname = (form) => {
    if (!form.first_name) {
        form.errors.firstname = validationMessages.common.required;
    } else if (form.firstname.length > 40) {
        form.errors.firstname = validationMessages.common.firstname;
    } else {
        delete form.errors.first_name;
    }
};

// 姓(カナ)のバリデーション 必須 / 50文字以内
export const validateLastnameKana = (form) => {
    if (!form.last_name_kana) {
        form.errors.lastname_kana = validationMessages.common.required;
    } else if (form.lastname_kana.length > 50) {
        form.errors.lastname_kana = validationMessages.common.lastname_kana;
    } else {
        delete form.errors.last_name_kana;
    }
};

// 名(カナ)のバリデーション 必須 / 50文字以内
export const validateFirstnameKana = (form) => {
    if (!form.first_name_kana) {
        form.errors.firstname_kana = validationMessages.common.required;
    } else if (form.firstname_kana.length > 50) {
        form.errors.firstname_kana = validationMessages.common.firstname_kana;
    } else {
        delete form.errors.first_name_kana;
    }
};

// 続柄のバリデーション 必須 / 20文字以内
export const validateRelationship = (form) => {
    if (!form.relationship) {
        form.errors.relationship = validationMessages.common.required;
    } else if (form.relationship.length > 20) {
        form.errors.relationship =
            validationMessages.common.relationship;
    } else {
        delete form.errors.relationship;
    }
};

// 生年月日のバリデーション 必須ではない / YYYY-MM-DD形式
export const validateBirth = (form) => {
    if (form.birth && !/^\d{4}-\d{2}-\d{2}$/.test(form.birth)) {
        form.errors.birth = validationMessages.common.birth;
    } else {
        delete form.errors.birth;
    }
};

// 性別のバリデーション 選択必須 / enum型 男性、女性、その他のいずれか
export const validateGender = (form) => {
    if (!form.gender) {
        form.errors.gender = validationMessages.common.required;
    } else {
        delete form.errors.birth;
    }
};

// 血液型のバリデーション 選択必須 / enum型 A、B、O、AB、その他のいずれか
export const validateBlood = (form) => {
    if (!form.blood) {
        form.errors.blood = validationMessages.common.required;
    } else {
        delete form.errors.blood;
    }
};

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

// 会社名のバリデーション 必須ではない / 50文字以内
export const validateCompanyName = (form) => {
    if (form.company_name.length > 50) {
        form.errors.company_name =
            validationMessages.common.company_name;
    } else {
        delete form.errors.company_name;
    }
};

// 会社の電話番号のバリデーション 必須ではない / 数字のみ / 10桁または11桁
export const validateCompanyPhoneNumber = (form) => {
    if (form.company_phone_number && !/^\d+$/.test(form.company_phone_number)) {
        form.errors.company_phone_number =
            validationMessages.common.company_phone_number;
    } else if (
        form.company_phone_number.length !== 10 &&
        form.company_phone_number.length !== 11
    ) {
        form.errors.company_phone_number =
            validationMessages.common.company_phone_number_length;
    } else {
        delete form.errors.company_phone_number;
    }
};
export const validateAllFields = (form) => {
    validateLastname(form);
    validateFirstname(form);
    validateLastnameKana(form);
    validateFirstnameKana(form);
    validateRelationShip(form);
    validateBirth(form);
    validateGender(form);
    validateBlood(form);
    validateMobileNumber(form);
    validateCompanyName(form);
    validateCompanyPhoneNumber(form);
};

import validationMessages from "@/Constants/validationMessages";

// メンバーオプション 必須
export const validateMemberOptionId = (form) => {
    if (!form.member_option_id) {
        form.errors.member_option_id = validationMessages.common.required;
    } else {
        delete form.errors.member_option_id;
    }
};

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

// 生年月日のバリデーション 必須 / YYYY-MM-DD形式
export const validateBirth = (form) => {
    if (!form.birth) {
        form.errors.birth = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.birth)) {
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
};

// 職歴のバリデーション / 100文字以内
export const validatePersonalHistory = (form) => {
    if (form.personal_history.length > 100) {
        form.errors.personal_history =
            validationMessages.common.personal_history;
    } else {
        delete form.errors.personal_history;
    }
};

// 会員番号のバリデーション 必須ではない/ 英数字のみ / 16桁以内
export const validateMemberNo = (form) => {
    if (form.member_no && !/^[a-zA-Z0-9]+$/.test(form.member_no)) {
        form.errors.member_no = validationMessages.common.member_no;
    } else if (form.member_no && form.member_no.length > 16) {
        form.errors.member_no = validationMessages.common.member_no_length;
    } else {
        delete form.errors.member_no;
    }
};

// シリアル番号のバリデーション 必須ではない/ 英数字のみ / 16桁以内
export const validateSerialNo = (form) => {
    if (form.serial_no && !/^[a-zA-Z0-9]+$/.test(form.serial_no)) {
        form.errors.serial_no = validationMessages.common.serial_no;
    } else if (form.serial_no && form.serial_no.length > 16) {
        form.errors.serial_no = validationMessages.common.serial_no_length;
    } else {
        delete form.errors.serial_no;
    }
};

// 写真の許可のバリデーション 必須
export const validatePermissionPhoto = (form) => {
    if (!form.permission_photo) {
        form.errors.permission_photo = validationMessages.common.required;
    } else {
        delete form.errors.permission_photo;
    }
};

// DMの許可のバリデーション 必須
export const validatePermissionDm = (form) => {
    if (!form.permission_dm) {
        form.errors.permission_dm = validationMessages.common.required;
    } else {
        delete form.errors.permission_dm;
    }
};

// 備考のバリデーション / 100文字以内
export const validateRemarks = (form) => {
    if (form.remarks.length > 100) {
        form.errors.remarks = validationMessages.common.remarks;
    } else {
        delete form.errors.remarks;
    }
};

export const validateAllFields = (form) => {
    validateMemberOptionId(form);
    validateLastname(form);
    validateFirstname(form);
    validateLastnameKana(form);
    validateFirstnameKana(form);
    validateBirth(form);
    validateGender(form);
    validateBlood(form);
    validateMobileNumber(form);
    validateMobileNumberRelationship(form);
    validatePersonalHistory(form);
    validateMemberNo(form);
    validateSerialNo(form);
    validatePermissionPhoto(form);
    validatePermissionDm(form);
    validateRemarks(form);
};

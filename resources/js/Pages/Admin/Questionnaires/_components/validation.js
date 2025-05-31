import validationMessages from "@/Constants/validationMessages";

// アンケート設問名のバリデーション 必須 / 50文字以内
export const validateName = (form) => {
    if (!form.name) {
        form.errors.name = validationMessages.common.required;
    } else if (form.name.length > 50) {
        form.errors.name = validationMessages.event.name;
    } else {
        delete form.errors.name;
    }
};

// アンケート設問内容のバリデーション 必須 / 800文字以内
export const validateMainDescription = (form) => {
    if (!form.main_description) {
        form.errors.main_description = validationMessages.common.required;
    } else if (form.main_description.length > 800) {
        form.errors.main_description =
            validationMessages.questionnaire.main_description;
    } else {
        delete form.errors.main_description;
    }
};

// アンケート設問の補足説明のバリデーション 必須ではない / 800文字以内
export const validateSubDescription = (form) => {
    if (form.sub_description.length > 800) {
        form.errors.sub_description =
            validationMessages.questionnaire.sub_description;
    } else {
        delete form.errors.sub_description;
    }
};


// アンケート設問の注釈のバリデーション 必須ではない / 600文字以内
export const validateAnnotation = (form) => {
    if (form.annotation.length > 600) {
        form.errors.annotation = validationMessages.questionnaire.annotation;
    } else {
        delete form.errors.annotation;
    }
};

// ステータスのバリデーション 選択必須
export const validateStatus = (form) => {
    if (form.status === null || form.status === undefined) {
        form.errors.status = validationMessages.common.required;
    } else {
        delete form.errors.status;
    }
};

// 公開開始日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateStartDate = (form) => {
    if (!form.start_date) {
        form.errors.start_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.start_date)) {
        form.errors.start_date =
            validationMessages.common.start_date;
    } else {
        delete form.errors.start_date;
    }
};

// 公開開始時間 必須
export const validateStartTime = (form) => {
    if (!form.start_time) {
        form.errors.start_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.start_time)) {
        form.errors.start_time = validationMessages.common.start_time;
    } else {
        delete form.errors.start_time;
    }
};

// 公開終了日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateEndDate = (form) => {
    if (!form.end_date) {
        form.errors.end_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.end_date)) {
        form.errors.end_date =
            validationMessages.common.end_date;
    } else {
        delete form.errors.end_date;
    }
};

// 公開終了時間 必須
export const validateEndTime = (form) => {
    if (!form.end_time) {
        form.errors.end_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.end_time)) {
        form.errors.end_time = validationMessages.common.end_time;
    } else {
        delete form.errors.end_time;
    }
};

export const validateAllFields = (form) => {
    validateName(form);
    validateMainDescription(form);
    validateSubDescription(form);
    validateAnnotation(form);
    validateStatus(form);
    validateStartDate(form);
    validateStartTime(form);
    validateEndDate(form);
    validateEndTime(form);
};

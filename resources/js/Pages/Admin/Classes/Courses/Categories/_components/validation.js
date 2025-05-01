import validationMessages from "@/Constants/validationMessages";

// レッスンIDのバリデーション 選択必須
export const validateLessonId = (form) => {
    if (!form.lesson_id) {
        form.errors.lesson_id = validationMessages.common.required;
    } else {
        delete form.errors.lesson_id;
    }
};

// コースカテゴリー名のバリデーション 必須 / 50文字以内
export const validateName = (form) => {
    if (!form.name) {
        form.errors.name = validationMessages.common.required;
    } else if (form.name.length > 50) {
        form.errors.name = validationMessages.courseCategory.name;
    } else {
        delete form.errors.name;
    }
};

// レッスン内容のバリデーション 必須 / 1000文字以内
export const validateDescription = (form) => {
    if (!form.description) {
        form.errors.description = validationMessages.common.required;
    } else if (form.description.length > 1000) {
        form.errors.description = validationMessages.courseCategory.description;
    } else {
        delete form.errors.description;
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

// 開始日のバリデーション 正しい日付形式（YYYY-MM-DD） / 開始日は店舗の設立日以降の日付
export const validateStartDate = (form, establishedDate) => {
    if (form.start_date && !/^\d{4}-\d{2}-\d{2}$/.test(form.start_date)) {
        form.errors.start_date = validationMessages.common.start_date;
    } else if (
        form.start_date &&
        new Date(form.start_date) < new Date(establishedDate)
    ) {
        form.errors.start_date = `開始日はレッスンの開始日（${establishedDate}）以降の日付を選択してください。`;
    } else {
        delete form.errors.start_date;
    }
};

// 終了日のバリデーション 正しい日付形式（YYYY-MM-DD） / 終了日は開始日より後の日付
export const validateEndDate = (form) => {
    if (form.end_date && !/^\d{4}-\d{2}-\d{2}$/.test(form.end_date)) {
        form.errors.end_date = validationMessages.common.end_date;
    } else if (
        form.start_date &&
        form.end_date &&
        new Date(form.start_date) > new Date(form.end_date)
    ) {
        form.errors.end_date =
            validationMessages.common.end_date_after_start_date;
    } else {
        delete form.errors.end_date;
    }
};

export const validateAllFields = (form) => {
    validateStoreId(form);
    validateName(form);
    validateDescription(form);
    validateStatus(form);
    validateStartDate(form);
    validateEndDate(form);
};

/***
 *  ---- СТРАННИК ----
 *  ---- ИНСТРУКЦИЯ ---
 *
 *  система СТРАННИК это система призвана заменить миграции, упростить процес разработки проектов
 *
 *  СТРАННИК является системой контроля структуры базы данных.
 *
 *  Объект tables содержит список таблиц которые должны быть в базе (системные таблицы)
 *
 *  Ключи первого уровня это имена таблиц.
 *      Правила написания имен таблиц:
 *      1) Все имена пишутся исключительно в нижнем регистре
 *      2) В качестве разделителя использовать символ "_" (нижнее тере)
 *  Ключи второго уровня это имена полей:
 *      1) Базовые правила соответетствую правилам базы данных
 *          правила наименования полей:
 *      2) первичный ключ "id" не указывается в шаблоне он добавится автоматически
 *          если нужно исключить поле "id" из таблицы то укажте id: false,
 *          если нужно изменить параметры поля "id" то просто укажите его как и обычное поле
 *              id: {
 *                  type: int,
 *                  default: 0,
 *                  primary_key: true,
 *                  auto_increment: true
 *              }
 *          незабудьте указать что это первичный ключ primary_key: true
 *
 *      3) если поле является связующим  то имя поля должно быть следующего вида:
 *           id_{имя связующей таблицы без префикса "table_"}_table если установлен режим option.binding_fields: id_name_table
 или {имя связующей таблицы без префикса "table_"}_id если установлен режим option.binding_fields: name_id
 *      4) если в одной таблице требуется несколько связующих полей к одной итойже таблице
 *          то после пост-префикса ..._table или _id имени поля можно добавить любой дополнительный пост-превикс через символ "_"
 *          пример в режиме option.binding_fields: id_name_table :{
 *              id_users_table_create: 'id', // поля для связи с пользователями - кто создал запись в тукущей табице
 *              id_users_table_last_update: 'id' // поля для связи с пользователями - кто сделал посделнюю правку
 *              id_users_table_del: 'id' // поля для связи с пользователями - кто произвел мягкое удаление
 *          }
 пример в режиме option.binding_fields: name_id :{
 *              users_id_create: 'id', // поля для связи с пользователями - кто создал запись в тукущей табице
 *              users_id_last_update: 'id' // поля для связи с пользователями - кто сделал посделнюю правку
 *              users_id_del: 'id' // поля для связи с пользователями - кто произвел мягкое удаление
 *          }
 *  параметры полей могут указываться в нескольких форматах
 *      1) Полный (ввиде объекта параметров)
 *          type: '{тип поля в базе данных}' список типов будет указан ниже
 *          constraint: {размер поля} запвисит от типы может быть не обезательным
 *          default: {значение по умолчанию} если не указать то выставится автоматически: для числовых - 0; для тесктовых - ''; json - {}; ...
 *          index: true - если нужно индексировать поле
 *
 *          param: {...} параметры доп системы странника используются для конструктора отображения и конструктора полей в создоваемой системе
 *
 *      2) Сокращенный в виде строки
 *          {тип поля}[({размер поля})][_index`если нужно интексировать поле`]
 *          пример:
 *              {название поля в бд}: 'int_index', // поле integer(11) default 0 // c добавлением индекса по данному полю в таблице (имена индексов автоматически)
 *              {название поля в бд}: 'int(9)', // integer(9) default 0
 *              {название поля в бд}: 'varchar', // varchar(255) default '';
 *              {название поля в бд}: 'varchar(40)_index', //varchar(40) default ''; // c добавлением индекса по данному полю в таблице (имена индексов автоматически)
 *              {название поля в бд}: 'varchar(63)', // varchar(63) default '';
 *              {название поля в бд}: 'text', // text nullable; на поле типа text индек лучше не ставить
 *      3) Смешанный - массив из 2 параметров. Первый - это строка как во втором варианте а второй это объект "param" как в первом варианте
 *          пример:
 *              {название поля в бд}: ['int_index', {
 *                  type: 'number',
 *                  label: 'Проценты',
 *                  top_params: {
 *                      min: 0,
 *                      step: 1
 *                      max: 100,
 *                      default: 50,
 *                      placeholder: 'Проценты'
 *                  }
 *              }], ...
 *              в базе данных будет создано поле integer (11) default 0; и проиндексированно
 *              в конструкторе полей системы будет поле <input type="number"
 *
 *
 * параметры:
 *
 *
 * для того чтобы произвести любые изменения в базе данных просто исправте шаблон и сохраните
 * если странник работает в автоматическом режиме он тутже применит изменения
 * если в ручном то нужно будет запустить структуризацию
 *
 * отрицательная строна СТРАННИКА:
 *  минусом странника является невозможность переименовать созданную таблицу или поля
 *  (при переименовании поля или таблицы - старая таблица будет удалена и созданна новая без данных тоже и сменапи полей)
 *  этот минус присутствует по крайней мере на текущей версии реализации странника, но по опыту работы могу сказать что это ненужно
 *  коррекция имен нужна только на начальном этапе разработки функционала,когда в разрабатываемомо функционале еще нету критически важных данных
 *
 *
 *
 * type: increments, //(not to write: constraint and index)
 *            bigIncrements, //(not to write: constraint and index)
 *            int,
 *            big_int, //(not to write: constraint)
 *            text, //(not to write: constraint and index)
 *            longtext, //(not to write: constraint and index)
 *            varchar,
 *            float, //(not to write: constraint)
 *            decimal, //(not to write: constraint)
 *            bool, //(not to write: constraint)
 *            binary, //(not to write: constraint)
 *           'id' == 'int_index' // the field type is specified for linking fields



 top_parametrs - type:
 text,
 tel,
 password,
 textarea,
 date,
 date_sql,
 number,
 double,
 color,
 time,
 email,
 select,
 checkbox,
 edit,
 elements

 view - отображение в списке/ default - false
 edit - отображение при заполнении/ default -true
 auto_save - быстрое редактирование в списке/ default false
 select_list - отображение в списке связи / default false

 require: true - валидация при заполении| обезательно для заполнения
 unique: true - валидация при заполении| уникальное
 pattern: 'reg' - валидация при заполении| проверка заполнения по регулярному выражению
 */
let md5 = require('md5-nodejs');
global.password_hash = pass => md5(pass + 'losals_systems')
const
    tables = {
        users: {
            name: 'string',
            first_name: 'string',
            last_name: 'string',
            middle_name: 'string',
            date_birth: 'date',
            inn: 'string',
            surname:'string',
            name_company: {
                type: 'string',
                default: '',
            },
            position: {
                type: 'string',
                default: '',
            },
            email:'',
            work_email: 'string',
            contact_email:'string',
            phone: 'varchar',
            job_phone: 'varchar',
            email_verified_at: 'timestamp',
            password: 'string',
            education: 'string',
            profile_url: 'string',
            photo_url: 'string',
            doc_url: 'string',
            active: {
                type: 'bool',
                default: false
            },
            last_active: 'timestamp',
            remember_token: {
                type: 'varchar',
                constraint: 100,
                null: true,
                default: null
            },
            is_ur: 'bool', // является ли учетка юр лицом (аналог распределения ролей)
            parent: 'int', // если учетка не является юр лицом то она может быть привызана к юр лицу

            deleted_at: {
                type: 'timestamp',
                null: true,
                default: null,
            }
        },
        cart: {
            users_id: 'id',
            courses_id: 'id',
            count: 'int',
        },
        pay_courses: {
            users_id: 'id',
            courses_id: 'id',
            date_pay: {
                type: 'date',
                null: true,
                default: null,
            },
            amount: 'decimal',
            // signed_contract: {
            //     type: 'set',
            //     null: true,
            //     default: null,
            // },
            confirmation_study: {
                type: 'int',
                null: true,
                default: null,
            },
            datetime_start: {
                type: 'datetime',
                null: true,
                default: null,
            },
        },
        courses: {
            title: 'string',
            price: 'decimal',
            tmplate_doc: 'string',

        },
        lessons: {
            title: 'string',
            courses_id: 'id',
            url_curs: 'string',// ссылка на урок,
            type_lesson: 'string', // тип урока
            progress: 'int', // прогресс
            order: 'int', // последовательность
        },
        exams: {
            courses_id: 'id',
            url_lesson: 'string',
            progress: 'int'
        },
        admins: {
            name: 'string',
            surname: 'string',
            email: 'string',
            email_verified_at: 'timestamp',
            password: 'string',
            active: {
                type: 'bool',
                default: false
            },
            last_active: {type: 'timestamp'},
            remember_token: {
                type: 'varchar',
                constraint: 100,
                null: true,
                default: null
            },
            role: 'int' // роли аднимистраторов 1 - полный админ; 2 - админимтратор сайта
        },
        password_resets_users: {
            email: 'varchar_index',
            token: 'varchar',
            created_at: 'timestamp'
        },
        password_resets_admins: {
            email: 'varchar_index',
            token: 'varchar',
            created_at: 'timestamp'
        },


    },

    data = { // автоматическое базовое заполнение

    }
;

module.exports = {tables, data};
# [SF ArTech Система](../README.md)

# Таблицы
Их можно разделить на 4 группы: данные авторизации, данные офферов и ордеров, данные логов и данные-теги графиков.

## Данные авторизации
Таблицы создаются автоматически внешней компонентой delight-im/auth. Используется таблица **users** (т.к. весь механизм авторизации не задействован):

<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>id</td>
        <td>Int</td>
        <td>Индекс</td>
    </tr>
    <tr>
        <td>email</td>
        <td>varchar(255)</td>
        <td>адрес пользователя</td>
    </tr>
    <tr>
        <td>password</td>
        <td>varchar(255)</td>
        <td>Пароль пользователя</td>
    </tr>
    <tr>
        <td>username</td>
        <td>varchar(255)</td>
        <td>Имя пользователя</td>
    </tr>
    <tr>
        <td>roles_mask</td>
        <td>Int</td>
        <td>Роль пользователя</td>
    </tr>
</table>

Возможные роли пользователя:
- 0 - нет роли,
- 1 - администратор,
- 163856 - заказчик,
- 131090 - веб-мастер.

## Данные офферов и ордеров
Таблица офферов **offers**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>id</td>
        <td>Int</td>
        <td>Индекс</td>
    </tr>
    <tr>
        <td>customer_id</td>
        <td>int</td>
        <td>id заказчика</td>
    </tr>
    <tr>
        <td>name</td>
        <td>varchar(255)</td>
        <td>Название оффера</td>
    </tr>
    <tr>
        <td>price</td>
        <td>Float</td>
        <td>Цена оффера</td>
    </tr>
    <tr>
        <td>url</td>
        <td>varchar(255)</td>
        <td>URL рекламируемого сайта</td>
    </tr>
    <tr>
        <td>keywords</td>
        <td>varchar(255)</td>
        <td>Набор ключевых слов поиска</td>
    </tr>
    <tr>
        <td>status</td>
        <td>Int</td>
        <td>Статус оффера (активен/деактивен)</td>
    </tr>
</table>

Таблица заказов **orders**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>id</td>
        <td>Int</td>
        <td>Индекс заказа</td>
    </tr>
    <tr>
        <td>master_id</td>
        <td>int</td>
        <td>id веб-мастера</td>
    </tr>
    <tr>
        <td>offer_id</td>
        <td>Int</td>
        <td>id оффера</td>
    </tr>
    <tr>
        <td>status</td>
        <td>Int</td>
        <td>Статус заказа</td>
    </tr>
</table>

## Данные логов
Таблица логов **logs**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>id</td>
        <td>Int</td>
        <td>Индекс записи</td>
    </tr>
    <tr>
        <td>time</td>
        <td>date</td>
        <td>дата-время записи</td>
    </tr>
    <tr>
        <td>master_id</td>
        <td>Int</td>
        <td>id веб-мастера</td>
    </tr>
    <tr>
        <td>customer_id</td>
        <td>Int</td>
        <td>id заказчика</td>
    </tr>
    <tr>
        <td>offer_id</td>
        <td>Int</td>
        <td>id оффера</td>
    </tr>
    <tr>
        <td>status</td>
        <td>Int</td>
        <td>Статус выполнения оффера</td>
    </tr>
</table>

Таблица учета выдачи линков **links**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>id</td>
        <td>Int</td>
        <td>Индекс записи</td>
    </tr>
    <tr>
        <td>time</td>
        <td>date</td>
        <td>дата-время записи</td>
    </tr>
    <tr>
        <td>master_id</td>
        <td>Int</td>
        <td>id веб-мастера</td>
    </tr>
    <tr>
        <td>offer_id</td>
        <td>Int</td>
        <td>id оффера</td>
    </tr>
</table>

## Данные-теги графиков
Эти таблицы статичны и никогда не меняются.
Таблица **year**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>month</td>
        <td>Int</td>
        <td>Месяцы 1-12</td>
    </tr>
</table>

Таблица **month**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>day</td>
        <td>Int</td>
        <td>Дни 1-31</td>
    </tr>
</table>

Таблица **day**
<table>
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Назначение</th>
    </tr>
    <tr>
        <td>hour</td>
        <td>Int</td>
        <td>Часы 0-23</td>
    </tr>
</table>

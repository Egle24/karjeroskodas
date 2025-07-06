<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #edf2f7; display: flex; justify-content: center; align-items: center; height: 95tisan servevh;  margin: 0; padding: 20px; color: black;">
<table style="background-color: white; width: 90%; max-width: 600px; border-spacing: 0; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); border-radius: 12px; text-align: left; box-sizing: border-box; margin: auto;">
    <tr>
        <th style="text-align: center; padding-bottom: 20px;">
            <img src="https://i.ibb.co/yYynhQ5/logo1.png" alt="Logo" style="max-width: 150px; height: auto;">
        </th>
    </tr>
    <tr>
        <td>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 20px; line-height: 1.5em; margin: 0 0 10px; text-align: left; font-weight: bold;">
                Sveiki, {{ $data['name'] }} {{ $data['surname'] }}!
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                Ačiū, kad užsiregistravote į renginį <strong>{{ $camp->title }}</strong>.
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 18px; line-height: 1.5em; margin: 0 0 10px; text-align: left; font-weight: bold;">
                Stovyklos informacija:
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                <strong>Data:</strong> {{ $camp->start_date }} – {{ $camp->end_date }} <br>
                <strong>Adresas:</strong> {{ $camp->address }} <br>
                <strong>Kaina:</strong> {{ $camp->priceForGuests }} EUR
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 18px; line-height: 1.5em; margin: 0 0 10px; text-align: left; font-weight: bold;">
                Jūsų pasirinkimai:
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                <strong>Stovyklos dalyvio/-ės mokestis:</strong> {{ $data['payment'] }} <br>
                <strong>Sąskaita išankstiniam apmokėjimui:</strong> {{ $data['invoice'] }} <br>
                <strong>Maitinimas:</strong> {{ $data['food_choice'] }} <br>
                <strong>Specialūs poreikiai:</strong> {{ $data['special_needs'] ?: 'Nėra' }}
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 18px; line-height: 1.5em; margin: 0 0 10px; text-align: left; font-weight: bold;">
                SVARBU
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                <strong>Mokestį pervesti į asociacijos „Karjeros kodas“ (Buveinės adresas: Ežero g. 4 – 47, Šiauliai) sąskaitą</strong> <br>
                <strong>Įmonės kodas: </strong> 304784990<br>
                <strong>Sąsk nr. </strong> LT24 7300 0101 5471 1132<br>
                <strong>BIC: </strong> HABALT22, AB Swedbank.<br>
                <strong>Paskirtis: </strong> {{ $camp->description }} {{ $camp->title }} dalyvio mokestis
            </p>

            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                Jei turite klausimų arba norite pakeisti savo pasirinkimus, susisiekite su mumis užpildydami susisiekimo formą.
            </p>
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; font-size: 16px; line-height: 1.5em; margin: 0 0 10px; text-align: left;">
                Ačiū, kad naudojatės mūsų sistema! <br><br>
                Pagarbiai, <br>
                Karjeros Kodas
            </p>
        </td>
    </tr>
</table>
</body>
</html>

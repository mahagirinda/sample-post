<div>
    <p style="background-color: blanchedalmond">
        Ini adalah halaman post inquiry.
    </p>
    <table style="background-color: #a0aec0; border: solid 1px #1a202c">
        @foreach($posts as $post)
            <tr style="border: solid 1px #1a202c">
                <td style="border: solid 1px #1a202c">
                    Title :
                </td>
                <td style="border: solid 1px #1a202c">
                    {{ $post->title }}
                </td>
            </tr>
            <tr>
                <td style="border: solid 1px #1a202c">
                    Isi :
                </td>
                <td style="border: solid 1px #1a202c">
                    {{ $post->body }}
                </td>
            </tr>
        @endforeach
    </table>
</div>

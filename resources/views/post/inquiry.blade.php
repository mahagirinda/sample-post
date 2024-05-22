<div>
    <p style="background-color: blanchedalmond">
        Ini adalah halaman post inquiry.
    </p>
    <table style="background-color: #a0aec0; border: solid 1px #1a202c">
        @foreach($posts as $post)
            <tr>
                <td>
                    Title :
                </td>
                <td>
                    {{ $post->title }}
                </td>
            </tr>
            <tr>
                <td>
                    Isi :
                </td>
                <td>
                    {{ $post->body }}
                </td>
            </tr>
        @endforeach
    </table>
</div>

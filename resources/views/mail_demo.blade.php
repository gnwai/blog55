<tr>
    <td style="background-color: #fff;border-radius:6px;padding:40px 40px 0;">
        <table>

            <tr><td>亲,下面的order_id 需要您手动入库到美仓哦!</td></tr>
            <tr height="30">
                @foreach ($order_id as $v)
                    <td>
                        {{$v}},
                    </td>
                @endforeach
            </tr>
        </table>
    </td>
</tr>
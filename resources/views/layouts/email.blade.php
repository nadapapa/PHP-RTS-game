<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title")</title>
    <style type="text/css">
        p {
            margin: 10px 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        h1, h2, h3, h4, h5, h6 {
            display: block;
            margin: 0;
            padding: 0;
        }

        img, a img {
            border: 0;
            height: auto;
            outline: none;
            text-decoration: none;
        }

        body, #bodyTable, #bodyCell {
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        #outlook a {
            padding: 0;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        p, a, li, td, blockquote {
            mso-line-height-rule: exactly;
        }

        a[href^=tel], a[href^=sms] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        p, a, li, td, body, table, blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        #bodyCell {
            padding: 10px;
        }

        .templateContainer {
            max-width: 600px !important;
        }

        .mcnTextContent {
            word-break: break-all;
        }

        .mcnTextContent img {
            height: auto !important;
        }

        body, #bodyTable {

            background-color: #dbdbdb;
        }

        #bodyCell {

            border-top: 0;
        }

        .templateContainer {

            border: 0;
        }

        h1 {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 26px;

            font-style: normal;

            font-weight: bold;

            line-height: 32px;

            letter-spacing: normal;

            text-align: left;
        }

        h2 {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 22px;

            font-style: normal;

            font-weight: bold;

            line-height: 30px;
            letter-spacing: normal;

            text-align: left;
        }

        h3 {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 20px;

            font-style: normal;

            font-weight: bold;

            line-height: 26px;

            letter-spacing: normal;

            text-align: left;
        }

        h4 {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 18px;

            font-style: normal;

            font-weight: bold;

            line-height: 24px;

            letter-spacing: normal;

            text-align: left;
        }

        #templatePreheader {

            background-color: #FAFAFA;

            border-top: 0;

            border-bottom: 0;

            padding-top: 9px;

            padding-bottom: 9px;
        }

        #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {

            color: #656565;

            font-family: Helvetica, sans-serif;

            font-size: 12px;

            line-height: 18px;

            text-align: left;
        }

        #templatePreheader .mcnTextContent a, #templatePreheader .mcnTextContent p a {

            color: #656565;

            font-weight: normal;

            text-decoration: underline;
        }

        #templateHeader {

            background-color: #FFFFFF;

            border-top: 0;

            border-bottom: 0;

            padding-top: 9px;

            padding-bottom: 0;
        }

        #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 16px;

            line-height: 24px;

            text-align: left;
        }

        #templateHeader .mcnTextContent a, #templateHeader .mcnTextContent p a {

            color: #2BAADF;

            font-weight: normal;

            text-decoration: underline;
        }

        #templateBody {

            background-color: #ffffff;

            border-top: 0;

            border-bottom: 2px solid #EAEAEA;

            padding-top: 0;

            padding-bottom: 9px;
        }

        #templateBody .mcnTextContent, #templateBody .mcnTextContent p {

            color: #202020;

            font-family: Helvetica, sans-serif;

            font-size: 16px;

            line-height: 24px;

            text-align: left;
        }

        #templateBody .mcnTextContent a, #templateBody .mcnTextContent p a {

            color: #2BAADF;

            font-weight: normal;

            text-decoration: underline;
        }

        #templateFooter {

            background-color: #ffffff;

            border-top: 0;

            border-bottom: 0;

            padding-top: 9px;

            padding-bottom: 9px;
        }

        #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {

            color: #656565;

            font-family: Helvetica, sans-serif;

            font-size: 12px;

            line-height: 18px;

            text-align: center;
        }

        #templateFooter .mcnTextContent a, #templateFooter .mcnTextContent p a {

            color: #656565;

            font-weight: normal;

            text-decoration: underline;
        }

        @media only screen and (min-width: 768px) {
            .templateContainer {
                width: 600px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body, table, td, p, a, li, blockquote {
                -webkit-text-size-adjust: none !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            #bodyCell {
                padding-top: 10px !important;
            }

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {
            .mcnCaptionLeftContentOuter .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
                padding-top: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

        }

        @media only screen and (max-width: 480px) {

            h1 {

                font-size: 22px !important;

                line-height: 28px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            h2 {

                font-size: 20px !important;

                line-height: 26px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            h3 {

                font-size: 18px !important;

                line-height: 24px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            h4 {

                font-size: 16px !important;

                line-height: 22px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            .mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {

                font-size: 14px !important;

                line-height: 22px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            #templatePreheader {

                display: block !important;
            }

        }

        @media only screen and (max-width: 480px) {

            #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {

                font-size: 14px !important;

                line-height: 22px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {

                font-size: 16px !important;

                line-height: 24px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            #templateBody .mcnTextContent, #templateBody .mcnTextContent p {

                font-size: 16px !important;

                line-height: 24px !important;
            }

        }

        @media only screen and (max-width: 480px) {

            #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {

                font-size: 14px !important;

                line-height: 22px !important;
            }

        }</style>
</head>
<body>
<div style="text-align: center;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->

                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                    <tr>
                        <td valign="top" id="templatePreheader"></td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateHeader"></td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateBody">
                            <table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" valign="top">

                                        <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0"
                                               cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>

                                                <td class="mcnTextContent" style="padding: 9px 18px; line-height: 150%;"
                                                    valign="top">

                                                    <h1>@yield("greeting")</h1>

                                                    @yield("content")

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="mcnButtonBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody class="mcnButtonBlockOuter">
                                <tr>
                                    <td style="padding: 0 18px 18px;"
                                        class="mcnButtonBlockInner" align="center" valign="top">
                                        <table class="mcnButtonContentContainer"
                                               style="border-collapse: separate ! important;border-radius: 3px;background-color: #33B63E;"
                                               border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-family: Arial, sans-serif; font-size: 16px; padding: 15px;"
                                                    class="mcnButtonContent" align="center" valign="middle">
                                                    @yield("button")
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateFooter">
                            <table class="mcnFollowBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody class="mcnFollowBlockOuter">
                                <tr>
                                    <td style="padding:9px" class="mcnFollowBlockInner" align="center" valign="top">
                                        <table class="mcnFollowContentContainer" border="0" cellpadding="0"
                                               cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td style="padding-left:9px;padding-right:9px;" align="center">
                                                    <table class="mcnFollowContent" border="0" cellpadding="0"
                                                           cellspacing="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="padding-top:9px; padding-right:9px; padding-left:9px;"
                                                                align="center" valign="top">
                                                                <table border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td valign="top">
                                                                                                                                                       <table align="left" border="0"
                                                                                   cellpadding="0" cellspacing="0">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td style="padding-right:0; padding-bottom:9px;"
                                                                                        class="mcnFollowContentItemContainer"
                                                                                        valign="top">
                                                                                        <table class="mcnFollowContentItem"
                                                                                               border="0"
                                                                                               cellpadding="0"
                                                                                               cellspacing="0"
                                                                                               width="100%">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td style="padding: 5px 10px 5px 9px;"
                                                                                                    align="left"
                                                                                                    valign="middle">
                                                                                                    <table align="left"
                                                                                                           border="0"
                                                                                                           cellpadding="0"
                                                                                                           cellspacing="0"
                                                                                                           width="">
                                                                                                        <tbody>
                                                                                                        <tr>

                                                                                                            <td class="mcnFollowIconContent"
                                                                                                                align="center"
                                                                                                                valign="middle"
                                                                                                                width="24">
                                                                                                                <a href="http://mailchimp.com"
                                                                                                                   target="_blank">
                                                                                                                    <img src="http://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png"
                                                                                                                         style="display:block;"
                                                                                                                         class=""
                                                                                                                         height="24"
                                                                                                                         width="24"></a>
                                                                                                            </td>


                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>


                                                                                                                                                    </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>
</body>
</html>
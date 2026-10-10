<?php

namespace App\Service;

use App\Repository\IssuedTicketRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Builder\Builder;

class QrCodeService
{
    public function __construct(private IssuedTicketRepository $issuedTicketRepository) {}

    public function generateQrCodePdf(string $transactionId): string
    {
        $issuedTickets = $this->issuedTicketRepository->findByTransactionId($transactionId);

        $html = '<html><body>';

        foreach ($issuedTickets as $issuedTicket) {
            $builder = new Builder(
                data: $issuedTicket->getQrCodeId(),
                size: 250,
                margin: 10
            );

            $qrCodeUri = $builder->build()->getDataUri();

            $html .= <<<HTML
                <div style="page-break-after: always; text-align: center; margin-bottom: 40px;">
                    <h2>{$issuedTicket->getTicketType()->getName()}</h2>
                    <img src="{$qrCodeUri}" alt="QR Code">
                </div>
            HTML;
        }

        $html .= '</body></html>';

        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return $dompdf->output();
    }
}

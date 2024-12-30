<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum LeadStatusEnum: string
{
    use IsKanbanStatus;

    case Presentation = "Presentation";
    case NeedAnalysis = "Need Analysis";
    case PricingSubmitted = "Pricing Submitted";
    case PricingNegociation = "Pricing Negotiation";
    case Negotiation = "Negotiation";
    case MSA_Princing_Review = "MSA & Pricing Review";
    case ClosedWon = "Closed – Won";
    case ClosedCancelled = "Closed – Cancelled";
    case ClosedLost = "Closed – Lost";
}

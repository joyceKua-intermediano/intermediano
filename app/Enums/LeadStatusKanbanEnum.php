<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum LeadStatusKanbanEnum: string
{
    use IsKanbanStatus;

    case Presentation = "Presentation";
    case NeedAnalysis = "Need Analysis";
    case PricingSubmitted = "Pricing Submitted";
    case PricingNegociation = "Pricing Negotiation";
    case MSA_Princing_Review = "MSA & Pricing Review";
    case Closed = "Closed";
}

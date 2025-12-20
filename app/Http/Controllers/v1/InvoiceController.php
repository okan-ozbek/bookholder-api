<?php

namespace app\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use app\Http\Requests\v1\CreateInvoiceRequest;
use app\Http\Requests\v1\UpdateInvoiceRequest;
use App\Models\Invoice;
use app\Services\v1\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceService $service) {}

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->listInvoices($request->all()));
    }

    public function show(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        return response()->json($invoice->toArray());
    }

    public function store(CreateInvoiceRequest $request): \Illuminate\Http\JsonResponse
    {
        $invoice = $this->service->createInvoice($request->validated()->toArray());

        return response()->json([
            'message' => 'Invoice created successfully',
            'url' => route('invoices.show', ['id' => $invoice->id])
        ], 201);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $this->service->updateInvoice($invoice, $request->validated()->toArray());

        return response()->json([
            'message' => 'Invoice updated successfully',
            'url' => route('invoices.show', ['id' => $invoice->id])
        ]);
    }

    public function setPaid(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->changeInvoiceStatus($invoice, \App\Enums\InvoiceStatusEnum::PAID);

        if ($result === true) {
            return response()->json(['message' => 'Invoice status updated successfully']);
        }

        return response()->json(['message' => 'Cannot change status of a finalized invoice'], 400);
    }

    public function setCancelled(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->changeInvoiceStatus($invoice, \App\Enums\InvoiceStatusEnum::CANCELLED);

        if ($result === true) {
            return response()->json(['message' => 'Invoice status updated successfully']);
        }

        return response()->json(['message' => 'Cannot change status of a finalized invoice'], 400);
    }

    public function setOverdue(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->changeInvoiceStatus($invoice, \App\Enums\InvoiceStatusEnum::OVERDUE);

        if ($result === true) {
            return response()->json(['message' => 'Invoice status updated successfully']);
        }

        return response()->json(['message' => 'Cannot change status of a finalized invoice'], 400);
    }

    public function destroy(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $this->service->deleteInvoice($invoice);

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}

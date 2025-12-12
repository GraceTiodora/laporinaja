<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiClient
{
    protected $baseUrl;
    protected $timeout = 30;

    public function __construct()
    {
        $this->baseUrl = env('BACKEND_API_URL', 'http://127.0.0.1:8001/api');
    }

    /**
     * Make GET request to API
     */
    public function get(string $endpoint, array $query = []): Response
    {
        return Http::timeout($this->timeout)
            ->get($this->buildUrl($endpoint), $query);
    }

    /**
     * Make POST request to API
     */
    public function post(string $endpoint, array $data = []): Response
    {
        return Http::timeout($this->timeout)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post($this->buildUrl($endpoint), $data);
    }

    /**
     * Make PUT request to API
     */
    public function put(string $endpoint, array $data = []): Response
    {
        return Http::timeout($this->timeout)
            ->put($this->buildUrl($endpoint), $data);
    }

    /**
     * Make DELETE request to API
     */
    public function delete(string $endpoint): Response
    {
        return Http::timeout($this->timeout)
            ->delete($this->buildUrl($endpoint));
    }

    /**
     * Build full URL
     */
    protected function buildUrl(string $endpoint): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    /**
     * Get all reports
     */
    public function getReports(array $filters = [])
    {
        return $this->get('reports', $filters);
    }

    /**
     * Get single report
     */
    public function getReport(int $id)
    {
        return $this->get("reports/{$id}");
    }

    /**
     * Create report
     */
    public function createReport(array $data)
    {
        return $this->post('reports', $data);
    }

    /**
     * Update report
     */
    public function updateReport(int $id, array $data)
    {
        return $this->put("reports/{$id}", $data);
    }

    /**
     * Delete report
     */
    public function deleteReport(int $id)
    {
        return $this->delete("reports/{$id}");
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        return $this->get('categories');
    }

    /**
     * Get single category
     */
    public function getCategory(int $id)
    {
        return $this->get("categories/{$id}");
    }

    /**
     * Get all comments for report
     */
    public function getComments(int $reportId = null)
    {
        $filters = [];
        if ($reportId) {
            $filters['report_id'] = $reportId;
        }
        return $this->get('comments', $filters);
    }

    /**
     * Create comment
     */
    public function createComment(array $data)
    {
        return $this->post('comments', $data);
    }

    /**
     * Get all solutions for report
     */
    public function getSolutions(int $reportId = null)
    {
        $filters = [];
        if ($reportId) {
            $filters['report_id'] = $reportId;
        }
        return $this->get('solutions', $filters);
    }

    /**
     * Create solution
     */
    public function createSolution(array $data)
    {
        return $this->post('solutions', $data);
    }

    /**
     * Create vote
     */
    public function createVote(array $data)
    {
        return $this->post('votes', $data);
    }

    /**
     * Delete vote
     */
    public function deleteVote(int $id)
    {
        return $this->delete("votes/{$id}");
    }

    /**
     * Get notifications
     */
    public function getNotifications(int $userId)
    {
        return $this->get('notifications', ['user_id' => $userId]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead(int $notificationId)
    {
        return $this->put("notifications/{$notificationId}/mark-as-read", []);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead(int $userId)
    {
        return $this->put('notifications/mark-all-as-read', ['user_id' => $userId]);
    }
}

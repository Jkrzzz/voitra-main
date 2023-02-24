<?php
namespace App\Notifications\Traits;

/**
 * Class NotificationAttribute.
 */
trait NotificationAttribute
{
    /**
     * @return string
     */
    public function getLabelClassAttribute()
    {
        $label_classes = array_flip(config('app-notification.label'));

        return str_replace('_', '-', $label_classes[$this->label]);
    }

    /**
     * @return string
     */
    public function getLabelTitleAttribute()
    {
        $label_titles = config('app-notification.label_title');

        return $label_titles[$this->label];
    }

    /**
     * @return string
     */
    public function getReferenceUrlAttribute()
    {
        $reference_url = url("/admin");

        // if (!is_null($this->reference()) && $this->reference() instanceof User) {
        //     $reference_url = url("/admin/users/{$this->reference_id}");
        // }
        // else if (!is_null($this->reference()) && $this->reference() instanceof Order) {
        //     $reference_url = url("/admin/orders/{$this->reference_id}/edit");
        // }

        switch ($this->sub_type) {
            case  1: // service_canceled
            case  2: // membership_canceled
            case 10: // postpaid_service_1_ok
            case 14: // postpaid_service_1_ng
            case 18: // postpaid_service_1_hr
                $reference_url = url("/admin/users/{$this->reference_id}");
                break;

            case  4: // user_est_requested
            case  5: // staff_estimated
            case  6: // user_edit_requested
            case  7: // staff_edited
            case  8: // postpaid_plan_1_ok
            case  9: // postpaid_plan_2_ok
            case 11: // postpaid_plan_1_plus_ok
            case 12: // postpaid_plan_1_ng
            case 13: // postpaid_plan_2_ng
            case 15: // postpaid_plan_1_plus_ng
            case 16: // postpaid_plan_1_hr
            case 17: // postpaid_plan_2_hr
            case 19: // postpaid_plan_1_plus_hr
            case 20: // admin_est_requested
            case 21: // admin_edit_requested
            case 22: // admin_message_created
            case 23: // staff_message_created
                $reference_url = url("/admin/orders/{$this->reference_id}/edit");
                break;

            case  3: // contact
                $reference_url = url("/admin/notifications/contact?id={$this->reference_id}");
                break;

            default:
                break;
        }

        return $reference_url;
    }

    /**
     * @return string
     */
    public function getStatusClassAttribute()
    {
        return ($this->read_at) ? 'read' : 'new';
    }
}

<?php

namespace App\Observers;

use App\Helpers\ItemRequestHelper;
use App\Models\Item;
use App\Models\ItemHistory;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     *
     * @return void
     */
    public function saved(Item $item)
    {
        ItemHistory::create([
            'item_id' => $item->id,
            'value' => $item->value,
            'timestamp' => $item->timestamp,
            'user_id' => $item->user_id,
        ]);

        ItemRequestHelper::clearCache($item->key);
        ItemRequestHelper::clearCache($item->key, $item->timestamp);
        ItemRequestHelper::clearAllRecordsCache();
    }
}

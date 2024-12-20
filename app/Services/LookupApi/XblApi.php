<?php declare(strict_types=1);

namespace App\Services\LookupApi;

use App\Interfaces\LookupClientApiInterface;
use App\Interfaces\LookupApiInterface;
use App\Traits\CommonLookupApiTrait;

class XblApi implements LookupApiInterface
{
    use CommonLookupApiTrait;

    protected string $xblUrlForId;
    protected string $xblUrlForUsername;

    public function __construct(protected LookupClientApiInterface $lookupApi)
    {
        $this->xblUrlForId = config('lookup.xbl_url_for_id');
        $this->xblUrlForUsername = config('lookup.xbl_url_for_username');
    }

    public function resolveApiUrl(?string $username, ?string $lookupId): ?string
    {
        // it seems that username has a precedence, hence if both id and username provided it takes username
        if ($username) {
            return $this->xblUrlForUsername . $username . "?type=username";
        }

        if ($lookupId) {
            return $this->xblUrlForId . $lookupId;
        }

        return null;
    }
}

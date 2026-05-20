# Universe Gate

The Universe Gate is a cross-server endgame feature that is separate from the existing local moon Jump Gate. The local Jump Gate still moves ships between a player's own moons; Universe Gate dispatches store cross-universe attack requests and exchange them with registered OGameX instances through REST endpoints.

## Rollout

The feature is disabled by default. Server operators must:

1. Set a stable Universe Gate identifier and universe name in **Admin > Server settings**.
2. Enable Universe Gate in the same settings page.
3. Register partner universes in **Admin > Universe Gate servers** with a shared secret of at least 32 characters.
4. Mark both sides as `active` after both instances have registered each other.
5. Players must opt in under **Options > General > Universe Gate** before they can send or receive cross-universe attacks.

## Security

All protected Universe Gate API calls use HMAC-SHA256 signatures with these headers:

- `X-Universe-Identifier`
- `X-Universe-Timestamp`
- `X-Universe-Nonce`
- `X-Universe-Signature`

The signature input is `timestamp.nonce.raw_body`. Nonces are cached briefly to prevent replay. Registration requests are stored as `pending` until an administrator activates the remote universe.

## API endpoints

- `GET /api/universe-gate/status`
- `POST /api/universe-gate/register`
- `POST /api/universe-gate/heartbeat`
- `POST /api/universe-gate/missions`
- `POST /api/universe-gate/missions/{uuid}/result`
- `POST /api/universe-gate/missions/{uuid}/return`

Responses include `api_version`, local universe identifier and universe name for compatibility checks.

## Current gameplay constraints

- Only attack missions are accepted for cross-universe dispatch.
- The player must opt in.
- The origin planet/moon must have a local Jump Gate level greater than zero.
- The target universe must be registered and active.
- The server enforces a high cooldown and a deuterium multiplier configured in server settings.
- Cross-universe dispatches are stored in `universe_gate_missions`; local moon Jump Gate cooldowns remain unchanged.

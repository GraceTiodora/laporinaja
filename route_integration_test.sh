#!/usr/bin/env bash
# Integration Test Script - Test critical routes for HTTP 500 errors
# Run: bash route_integration_test.sh

BASE_URL="http://127.0.0.1:8000"

echo "═════════════════════════════════════════════════════════════"
echo "  ROUTE INTEGRATION TEST"
echo "═════════════════════════════════════════════════════════════"
echo ""

CRITICAL_ROUTES=(
    "/"
    "/explore"
    "/my-reports"
    "/profile"
    "/notifications"
    "/messages"
    "/communities"
    "/login"
    "/register"
    "/simple-login"
)

ERRORS=0
SUCCESS=0

for route in "${CRITICAL_ROUTES[@]}"; do
    echo "Testing: $route"
    
    RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL$route")
    
    case $RESPONSE in
        200|302|301)
            echo "  ✅ HTTP $RESPONSE - OK"
            ((SUCCESS++))
            ;;
        500)
            echo "  ❌ HTTP 500 - SERVER ERROR"
            ((ERRORS++))
            ;;
        404)
            echo "  ⚠️  HTTP 404 - NOT FOUND"
            ((ERRORS++))
            ;;
        *)
            echo "  ℹ️  HTTP $RESPONSE"
            ;;
    esac
    echo ""
done

echo "═════════════════════════════════════════════════════════════"
echo "RESULTS: $SUCCESS passed, $ERRORS failed"
echo "═════════════════════════════════════════════════════════════"

exit $ERRORS
